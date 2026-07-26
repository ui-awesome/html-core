<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Base;

use UIAwesome\Html\Contracts\RenderableInterface;
use UIAwesome\Html\Core\Config\{ComponentContext, Config};
use UIAwesome\Html\Core\Event\{HasAfterRun, HasBeforeRun};
use UIAwesome\Html\Core\Exception\{ConfigException, Message};
use UIAwesome\Html\Core\Factory\SimpleFactory;

use function get_debug_type;

/**
 * Provides the base implementation for fluent HTML tag objects.
 *
 * Uses lifecycle hooks, class-level defaults, and application-scoped config recipes.
 */
abstract class BaseTag implements RenderableInterface
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
     * @throws ConfigException If a configuration key targets a property that is not a public instance property.
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
