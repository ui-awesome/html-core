<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

/**
 * Applies resolved config recipes to immutable component instances.
 *
 * Usage example:
 * ```php
 * use UIAwesome\Html\Core\Config\{ComponentContext, ConfigApplierInterface, Recipe};
 *
 * final class MethodCallApplier implements ConfigApplierInterface
 * {
 *     public function apply(
 *         object $component,
 *         Recipe $recipe,
 *         ComponentContext $context,
 *         bool $strict = true,
 *     ): object {
 *         foreach ($recipe->cookbook as $call) {
 *             $component = $component->{$call->method}(...$call->arguments);
 *         }
 *
 *         return $component;
 *     }
 * }
 * ```
 */
interface ConfigApplierInterface
{
    /**
     * Applies a recipe and returns the configured component instance.
     *
     * Usage example:
     * ```php
     * public function apply(
     *     object $component,
     *     \UIAwesome\Html\Core\Config\Recipe $recipe,
     *     \UIAwesome\Html\Core\Config\ComponentContext $context,
     *     bool $strict = true,
     * ): object {
     *     foreach ($recipe->cookbook as $call) {
     *         $component = $component->{$call->method}(...$call->arguments);
     *     }
     *
     *     return $component;
     * }
     * ```
     *
     * @param object $component Component to configure.
     * @param Recipe $recipe Resolved recipe to apply.
     * @param ComponentContext $context Semantic component context.
     * @param bool $strict Whether unknown or incompatible calls must fail.
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
