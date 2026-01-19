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
 * Base class for HTML tag objects with lifecycle hooks and begin/end support.
 *
 * Provides shared infrastructure for tag rendering, including `beforeRun()`/`afterRun()` hooks and a context-aware
 * begin/end stack for nested rendering. The stack is stored in a {@see WeakMap} keyed by the current {@see Fiber}
 * (or a sentinel object when running outside a fiber).
 *
 * Designed to be extended by concrete tag implementations that implement {@see BaseTag::run()} and optionally override
 * {@see BaseTag::runBegin()} for `begin()`/`end()` style rendering.
 *
 * Key features.
 * - Applies defaults and themes via {@see DefaultsProviderInterface} and {@see ThemeProviderInterface} providers.
 * - Creates and configures instances via {@see BaseTag::tag()} and {@see SimpleFactory}.
 * - Supports paired `begin()`/`end()` rendering using a per-context stack.
 * - Uses `WeakMap` and {@see Fiber} to isolate stacks between execution contexts.
 * - Wraps {@see BaseTag::run()} with `beforeRun()`/`afterRun()` hooks via {@see BaseTag::render()}.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseTag implements DefaultsProviderInterface, ThemeProviderInterface, Stringable
{
    use HasAfterRun;
    use HasBeforeRun;

    /**
     * Indicates whether the `begin()` method has been executed for this tag instance.
     *
     * Used internally to manage the tag rendering lifecycle and stack integrity.
     */
    private bool $beginExecuted = false;

    /**
     * Sentinel object representing the Main Thread in the WeakMap.
     *
     * Used when the code is running outside any Fiber.
     */
    private static stdClass|null $mainThread = null;

    /**
     * Fiber-specific stacks using weak references for automatic cleanup.
     *
     * @phpstan-var WeakMap<object, static[]>|null
     */
    private static WeakMap|null $stack = null;

    /**
     * Initializes a new tag instance.
     *
     * The constructor is final to enforce immutability and consistent instantiation via factory methods.
     */
    final public function __construct() {}

    /**
     * Renders the tag as a string.
     *
     * Invokes the `render()` method to produce the HTML representation of the tag.
     *
     * @return string Rendered HTML tag string.
     *
     * Usage example:
     * ```php
     * <?= $element ?>
     * ```
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
     * Adds one or more default providers to the tag instance.
     *
     * Applies configuration defaults from the specified provider classes to the tag.
     *
     * @param string ...$providers List of default provider class names.
     *
     * @return static Tag instance with applied default providers.
     *
     * @phpstan-param class-string<DefaultsProviderInterface> ...$providers
     *
     * Usage example:
     * ```php
     * $tag = Div::tag()->addDefaultProvider(\UIAwesome\Html\Provider\SomeDefaultProvider::class);
     * ```
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
     * Adds one or more theme providers to the tag instance.
     *
     * Applies theme configuration from the specified provider classes to the tag.
     *
     * @param string $name Theme name to apply.
     * @param string ...$themeProviders List of theme provider class names.
     *
     * @return static Tag instance with applied theme providers.
     *
     * @phpstan-param class-string<ThemeProviderInterface> ...$themeProviders
     *
     * Usage example:
     * ```php
     * $tag = Div::tag()->addThemeProvider('dark', \UIAwesome\Html\Provider\SomeThemeProvider::class);
     * ```
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
     * Applies a theme configuration to the tag instance.
     *
     * Returns an array of configuration values for the given tag and theme.
     *
     * @param BaseTag $tag Tag instance being configured.
     * @param string $theme Theme name to apply.
     *
     * @return array Configuration array for the theme.
     *
     * @phpstan-return mixed[]
     *
     * Usage example:
     * ```php
     * public function apply(self $tag, string $theme): array
     * {
     *     if ($tag instanceof ButtonTag === false) {
     *        return [];
     *     }
     *
     *     return match ($theme) {
     *         'dark' => ['class' => 'btn-dark'],
     *         'light' => ['class' => 'btn-light'],
     *         default => [],
     *     };
     * }
     * ```
     */
    public function apply(self $tag, string $theme): array
    {
        return [];
    }

    /**
     * Begins a tag rendering block and pushes the instance onto the context-specific stack.
     *
     * Identifies the current execution context (`Fiber` or `self::$mainThread`) and stores the tag instance in the
     * corresponding stack, ensuring safe nesting even in concurrent environments.
     *
     * @return string Empty string for output buffering compatibility.
     *
     * Usage example:
     * ```php
     * <?= Div::tag()->begin() ?>
     * Content inside the tag.
     * <?= Div::end() ?>
     * ```
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
     * Ends the most recently begun tag rendering block.
     *
     * Pops the tag instance from the current context's stack and render its HTML output.
     *
     * Automatically cleans up the stack entry if it becomes empty.
     *
     * @throws LogicException if no matching `begin()` call is found.
     * @throws RuntimeException if the tag class does not match the expected type.
     *
     * @return string Rendered HTML tag string.
     *
     * Usage example:
     * ```php
     * <?= Element::end() ?>
     * ```
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
     * Returns configuration defaults for the given tag instance.
     *
     * @param BaseTag $tag Tag instance being configured.
     *
     * @return array<string, mixed> Cookbook-style configuration array.
     *
     * @phpstan-return mixed[]
     *
     * Usage example:
     * ```php
     * <?= $tag->getDefaults($tag) ?>
     * ```
     */
    public function getDefaults(self $tag): array
    {
        return [];
    }

    /**
     * Renders the tag, applying before and after run event hooks.
     *
     * Executes the `beforeRun()` and `afterRun()` hooks around the core `run()` rendering logic.
     *
     * @return string Rendered HTML tag string, or empty string if rendering is skipped.
     *
     * Usage example:
     * ```php
     * <?= $tag->render() ?>
     * ```
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
     * - Defaults passed directly by the user to {@see tag()}.
     *
     * After construction, additional user modifications (via setter methods like `class`, `id`, `data`, etc.) and
     * theme overrides will always have the highest priority.
     *
     * @param array ...$defaults Configuration cookbook arrays. Each array maps "methodName" → arguments, and will be
     * applied in order.
     *
     * @return static Fully configured tag instance.
     *
     * @phpstan-param mixed[] ...$defaults
     *
     * Usage example:
     * ```php
     * $element = Div::tag(
     *     [
     *         'class' => 'container',
     *         'id' => 'main-div',
     *     ],
     * );
     * ```
     */
    public static function tag(array ...$defaults): static
    {
        /** @phpstan-var static $tag */
        $tag = SimpleFactory::create(static::class);

        $pipeline = [
            SimpleFactory::getDefaults(static::class),
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
     * Indicates whether the `begin()` method has been executed for this tag instance.
     *
     * Used internally for stack and lifecycle management.
     *
     * @return bool Returns `true` if `begin()` was executed, `false` otherwise.
     */
    protected function isBeginExecuted(): bool
    {
        return $this->beginExecuted;
    }

    /**
     * Handles the logic for the `begin()` method.
     *
     * By default, this method throws a `LogicException`, indicating that the tag does not support block rendering.
     *
     * Subclasses that support `begin()`/`end()` rendering should override this method to provide the appropriate
     * behavior.
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
     * Retrieves the unique identifier for the current execution context.
     *
     * Returns the current `Fiber` instance if running in an async context or the `stdClass` sentinel object if running
     * in the {@see self::$mainThread}.
     *
     * @phpstan-return Fiber<mixed, mixed, mixed, mixed>|stdClass
     */
    private static function getContextId(): Fiber|stdClass
    {
        return Fiber::getCurrent() ?? self::$mainThread ??= new stdClass();
    }

    /**
     * Retrieves the stack for the current execution context.
     *
     * Initializes the WeakMap if necessary and ensures an array exists for the current key.
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
