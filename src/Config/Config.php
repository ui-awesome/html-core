<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

use LogicException;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Factory\ComponentFactoryInterface;
use UIAwesome\Html\Core\Theme\ThemeInterface;

/**
 * Holds immutable application-scoped config services without global mutable state.
 *
 * Usage example:
 * ```php
 * $config = new \UIAwesome\Html\Core\Config\Config($theme, $applier);
 * $component = $config->apply($component, new \UIAwesome\Html\Core\Config\ComponentContext('field.control.email'));
 * ```
 */
final readonly class Config
{
    /**
     * @param ThemeInterface $theme Theme resolving recipes for component contexts.
     * @param ConfigApplierInterface $applier Applier executing recipe calls on component instances.
     * @param ComponentFactoryInterface|null $factory Factory creating components, or `null` to disable creation.
     * @param bool $strict Whether unknown or incompatible calls must fail.
     */
    public function __construct(
        public ThemeInterface $theme,
        public ConfigApplierInterface $applier,
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
     * Creates a component through the configured component factory.
     *
     * Usage example:
     * ```php
     * $component = $config->create(new \UIAwesome\Html\Core\Config\ComponentContext('field.control.email'));
     * ```
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @throws LogicException If no component factory is configured.
     *
     * @return object Created component instance.
     */
    public function create(ComponentContext $context): object
    {
        if ($this->factory === null) {
            throw new LogicException(
                Message::CONFIG_DOES_NOT_DEFINE_COMPONENT_FACTORY->getMessage(),
            );
        }

        return $this->factory->create($context);
    }
}
