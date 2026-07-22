<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

use LogicException;
use UIAwesome\Html\Core\Exception\{ConfigException, Message};
use UIAwesome\Html\Core\Factory\ComponentFactoryInterface;
use UIAwesome\Html\Core\Theme\ThemeInterface;

/**
 * Holds immutable application-scoped config services without global mutable state.
 *
 * Usage example:
 * ```php
 * $config = new \UIAwesome\Html\Core\Config\Config($theme);
 * $component = $config->apply($component, new \UIAwesome\Html\Core\Config\ComponentContext('field.control.email'));
 * ```
 */
final readonly class Config
{
    /**
     * @param ThemeInterface $theme Theme resolving recipes for component contexts.
     * @param ConfigApplierInterface $applier Applier executing recipe calls on component instances.
     * @param ComponentFactoryInterface|null $factory Factory creating components, or `null` to disable creation.
     * @param bool $strict Whether unavailable methods or incompatible return values must fail.
     */
    public function __construct(
        public ThemeInterface $theme,
        public ConfigApplierInterface $applier = new ConfigApplier(),
        public ComponentFactoryInterface|null $factory = null,
        public bool $strict = true,
    ) {}

    /**
     * Applies every theme recipe resolved for the component context in declaration order.
     *
     * Usage example:
     * ```php
     * $component = $config->apply($component, new \UIAwesome\Html\Core\Config\ComponentContext('field.control.email'));
     * ```
     *
     * @param object $component Component to configure.
     * @param ComponentContext $context Semantic component context.
     *
     * @throws ConfigException If a resolved recipe cannot be applied to the component.
     *
     * @return object Configured component instance.
     */
    public function apply(object $component, ComponentContext $context): object
    {
        foreach ($this->theme->getRecipes($context) as $recipe) {
            $component = $this->applier->apply($component, $recipe, $context, $this->strict);
        }

        return $component;
    }

    /**
     * Creates a component through the configured component factory and applies the resolved theme recipes.
     *
     * Usage example:
     * ```php
     * $component = $config->create(new \UIAwesome\Html\Core\Config\ComponentContext('field.control.email'));
     * ```
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @throws ConfigException If a resolved recipe cannot be applied to the created component.
     * @throws LogicException If no component factory is configured.
     *
     * @return object Created and configured component instance.
     */
    public function create(ComponentContext $context): object
    {
        if ($this->factory === null) {
            throw new LogicException(
                Message::CONFIG_DOES_NOT_DEFINE_COMPONENT_FACTORY->getMessage(),
            );
        }

        return $this->apply($this->factory->create($context), $context);
    }
}
