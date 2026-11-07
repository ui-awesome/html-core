<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

/**
 * Applies resolved config recipes to immutable component instances.
 */
interface ConfigApplierInterface
{
    /**
     * Applies a recipe and returns the configured component instance.
     *
     * @param object $component Component to configure.
     * @param Recipe $recipe Resolved recipe to apply.
     * @param ComponentContext $context Semantic component context.
     * @param bool $strict Whether unavailable methods or incompatible return values must fail instead of being
     * skipped.
     *
     * @return object Configured component instance.
     */
    public function apply(
        object $component,
        Recipe $recipe,
        ComponentContext $context,
        bool $strict = true,
    ): object;
}
