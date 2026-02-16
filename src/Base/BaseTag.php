<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Base;

use Fiber;
use LogicException;
use RuntimeException;
use stdClass;
use Stringable;
use UIAwesome\Html\Core\Event\{HasAfterRun, HasBeforeRun};
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Provider\{DefaultsProviderInterface, ThemeProviderInterface};
use WeakMap;

use function array_pop;

/**
 * Provides the base implementation for fluent HTML tag objects.
 *
 * Uses lifecycle hooks and a context-aware begin/end stack backed by {@see WeakMap} and {@see Fiber}.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseTag implements DefaultsProviderInterface, ThemeProviderInterface, Stringable
{
    use HasAfterRun;
    use HasBeforeRun;

    /**
     * Tracks whether `begin()` was executed for this instance.
     */
    private bool $beginExecuted = false;

    /**
     * Stores the sentinel object for the main execution context.
     */
    private static stdClass|null $mainThread = null;

    /**
     * Stores per-context begin/end stacks.
     *
     * @phpstan-var WeakMap<object, static[]>|null
     */
    private static WeakMap|null $stack = null;

    /**
     * Initializes a new tag instance.
     */
    final public function __construct() {}

    /**
     * Returns the rendered tag string.
     *
     * Usage example:
     * ```php
     * <?= $element ?>
     * ```
     *
     * @return string Rendered HTML tag string.
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Renders the core HTML output for the tag.
     *
     * Must be implemented by concrete subclasses to generate the tag's HTML representation.
     *
     * @return string Rendered HTML tag string.
     */
    abstract protected function run(): string;

    /**
     * Applies one or more default providers.
     *
     * Usage example:
     * ```php
     * $tag = \App\Html\SomeTag::tag()
     *     ->addDefaultProvider(\App\Html\SomeDefaultProvider::class);
     * ```
     *
     * @param string ...$providers List of default provider class names.
     *
     * @return static Tag instance with applied default providers.
     *
     * @phpstan-param class-string<DefaultsProviderInterface> ...$providers
     */
    public function addDefaultProvider(string ...$providers): static
    {
        $tag = $this;

        foreach ($providers as $provider) {
            $provider = new $provider();

            $definitions = $provider->getDefaults($tag);

            if ($definitions !== []) {
                /** @phpstan-var static $tag */
                $tag = SimpleFactory::configure($tag, $definitions);
            }
        }

        return $tag;
    }

    /**
     * Applies one or more theme providers.
     *
     * Usage example:
     * ```php
     * $tag = \App\Html\SomeTag::tag()
     *     ->addThemeProvider('dark', \App\Html\SomeThemeProvider::class);
     * ```
     *
     * @param string $name Theme name to apply.
     * @param string ...$themeProviders List of theme provider class names.
     *
     * @return static Tag instance with applied theme providers.
     *
     * @phpstan-param class-string<ThemeProviderInterface> ...$themeProviders
     */
    public function addThemeProvider(string $name, string ...$themeProviders): static
    {
        $tag = $this;

        foreach ($themeProviders as $providerClass) {
            $provider = new $providerClass();

            $definitions = $provider->apply($tag, $name);

            if ($definitions !== []) {
                /** @phpstan-var static $tag */
                $tag = SimpleFactory::configure($tag, $definitions);
            }
        }

        return $tag;
    }

    /**
     * Returns theme configuration for the given tag.
     *
     * Usage example:
     * ```php
     * public function apply(self $tag, string $theme): array
     * {
     *     return $theme === 'dark' ? ['class' => 'btn-dark'] : [];
     * }
     * ```
     *
     * @param BaseTag $tag Tag instance being configured.
     * @param string $theme Theme name to apply.
     *
     * @return array Configuration array for the theme.
     *
     * @phpstan-return mixed[]
     */
    public function apply(self $tag, string $theme): array
    {
        return [];
    }

    /**
     * Starts begin/end rendering for this instance.
     *
     * Usage example:
     * ```php
     * <?= \App\Html\SomeTag::tag()->begin() ?>
     * Content inside the tag.
     * <?= \App\Html\SomeTag::end() ?>
     * ```
     *
     * @return string Empty string for output buffering compatibility.
     */
    final public function begin(): string
    {
        $this->beginExecuted = true;

        $renderBegin = $this->runBegin();
        $stack = self::getContextStack();

        $stack[] = $this;

        self::$stack?->offsetSet(self::getContextId(), $stack);

        return $renderBegin;
    }

    /**
     * Ends the most recent begin/end rendering block for the current class.
     *
     * Usage example:
     * ```php
     * <?= \App\Html\SomeTag::end() ?>
     * ```
     *
     * @throws LogicException if no matching `begin()` call is found.
     * @throws RuntimeException if the tag class does not match the expected type.
     *
     * @return string Rendered HTML tag string.
     */
    final public static function end(): string
    {
        $key = self::getContextId();
        $stack = self::getContextStack();

        if ($stack === []) {
            throw new LogicException(
                Message::UNEXPECTED_END_CALL_NO_BEGIN->getMessage(static::class),
            );
        }

        $tag = array_pop($stack);

        if ($stack === []) {
            self::$stack?->offsetUnset($key);
        } else {
            self::$stack?->offsetSet($key, $stack);
        }

        $tagClass = $tag::class;

        if ($tagClass !== static::class) {
            throw new RuntimeException(
                Message::TAG_CLASS_MISMATCH_ON_END->getMessage($tagClass, static::class),
            );
        }

        return $tag->render();
    }

    /**
     * Returns default configuration for the given tag.
     *
     * Usage example:
     * ```php
     * public function getDefaults(self $tag): array
     * {
     *     return ['class' => 'default'];
     * }
     * ```
     *
     * @param BaseTag $tag Tag instance being configured.
     *
     * @return array<string, mixed> Cookbook-style configuration array.
     *
     * @phpstan-return mixed[]
     */
    public function getDefaults(self $tag): array
    {
        return [];
    }

    /**
     * Renders the tag with lifecycle hooks.
     *
     * Usage example:
     * ```php
     * <?= $tag->render() ?>
     * ```
     *
     * @return string Rendered HTML tag string, or empty string if rendering is skipped.
     */
    final public function render(): string
    {
        if ($this->beforeRun() === false) {
            return '';
        }

        return $this->afterRun($this->run());
    }

    /**
     * Creates and configures a new tag instance.
     *
     * Configuration priority (from weakest to strongest):
     * - Global defaults defined via {@see SimpleFactory::setDefaults()}.
     * - Class defaults from {@see BaseTag::loadDefault()}.
     * - Defaults passed directly by the user to {@see tag()}.
     *
     * Usage example:
     * ```php
     * $element = \App\Html\SomeTag::tag(['class' => 'container']);
     * ```
     *
     * @param array ...$defaults Configuration cookbook arrays. Each array maps "methodName" → arguments, and will be
     * applied in order.
     *
     * @return static Fully configured tag instance.
     *
     * @phpstan-param mixed[] ...$defaults
     */
    public static function tag(array ...$defaults): static
    {
        /** @phpstan-var static $tag */
        $tag = SimpleFactory::create(static::class);

        $pipeline = [
            SimpleFactory::getDefaults(static::class),
            $tag->loadDefault(),
            ...$defaults,
        ];

        foreach ($pipeline as $definition) {
            if ($definition !== []) {
                /** @phpstan-var static $tag */
                $tag = SimpleFactory::configure($tag, $definition);
            }
        }

        return $tag;
    }

    /**
     * Indicates whether `begin()` was executed for this instance.
     *
     * @return bool Returns `true` if `begin()` was executed, otherwise `false`.
     */
    protected function isBeginExecuted(): bool
    {
        return $this->beginExecuted;
    }

    /**
     * Returns class-level default definitions.
     *
     * Override this method in subclasses to provide default configuration values.
     *
     * @return array Cookbook style configuration array.
     *
     * @phpstan-return array<string, mixed>
     */
    protected function loadDefault(): array
    {
        return [];
    }

    /**
     * Returns the opening tag for begin/end rendering.
     *
     * Override this method in subclasses that support `begin()` and `end()`.
     *
     * @throws LogicException if the tag does not support `begin()`/`end()` rendering.
     *
     * @return string Opening HTML tag.
     *
     * @infection-ignore-all
     */
    protected function runBegin(): string
    {
        throw new LogicException(
            Message::TAG_DOES_NOT_SUPPORT_BEGIN->getMessage(static::class),
        );
    }

    /**
     * Returns the identifier for the current execution context.
     *
     * @phpstan-return Fiber<mixed, mixed, mixed, mixed>|stdClass
     */
    private static function getContextId(): Fiber|stdClass
    {
        return Fiber::getCurrent() ?? self::$mainThread ??= new stdClass();
    }

    /**
     * Returns the begin/end stack for the current execution context.
     *
     * @phpstan-return array<array-key, static>
     */
    private static function getContextStack(): array
    {
        self::$stack ??= new WeakMap();

        $key = self::getContextId();

        if (self::$stack->offsetExists($key) === false) {
            self::$stack->offsetSet($key, []);
        }

        return self::$stack->offsetGet($key);
    }
}
