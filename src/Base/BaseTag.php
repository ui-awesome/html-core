<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Base;

use UIAwesome\Html\Contracts\RenderableInterface;
use UIAwesome\Html\Core\Event\{HasAfterRun, HasBeforeRun};
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Provider\{DefaultsProviderInterface, ThemeProviderInterface};

/**
 * Provides the base implementation for fluent HTML tag objects.
 *
 * Uses lifecycle hooks and provider-based default and theme configuration.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseTag implements DefaultsProviderInterface, ThemeProviderInterface, RenderableInterface
{
    use HasAfterRun;
    use HasBeforeRun;

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
}
