<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Base;

use UIAwesome\Html\Contracts\RenderableInterface;
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Core\Event\{HasAfterRun, HasBeforeRun};
use UIAwesome\Html\Core\Exception\{ConfigException, Message};
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Provider\{DefaultsProviderInterface, ThemeProviderInterface};

use function get_debug_type;

/**
 * Provides the base implementation for fluent HTML tag objects.
 *
 * Uses lifecycle hooks and provider-based default and theme configuration.
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
     * Applies application-scoped config recipes to this tag.
     *
     * Calls made after this method remain local overrides because the config is applied immediately.
     *
     * Usage example:
     * ```php
     * $tag = \App\Html\SomeTag::tag()
     *     ->config($config, new \UIAwesome\Html\Core\Config\ComponentContext('field.control.email'))
     *     ->id('email');
     * ```
     *
     * @param Config $config Application-scoped config service.
     * @param ComponentContext $context Semantic context used to resolve recipes.
     *
     * @throws ConfigException If a resolved recipe cannot be applied or a custom config applier returns an
     * incompatible component.
     *
     * @return static Configured tag instance.
     */
    public function config(Config $config, ComponentContext $context): static
    {
        $tag = $config->apply($this, $context);

        if (($tag instanceof $this) === false) {
            throw new ConfigException(
                Message::CONFIG_RETURNED_INCOMPATIBLE_COMPONENT->getMessage(
                    $context->component,
                    get_debug_type($this),
                    get_debug_type($tag),
                ),
            );
        }

        return $tag;
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
     * - Class defaults from {@see BaseTag::loadDefault()}.
     * - Defaults passed directly by the user to {@see tag()}.
     *
     * Application-scoped recipes should be applied afterward through {@see BaseTag::config()}.
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
