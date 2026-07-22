<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Theme;

use UIAwesome\Html\Core\Config\{ComponentContext, Recipe};

/**
 * Resolves ordered config recipes for semantic component contexts.
 *
 * Usage example:
 * ```php
 * use UIAwesome\Html\Core\Config\{Call, ComponentContext, Cookbook, Recipe};
 * use UIAwesome\Html\Core\Theme\ThemeInterface;
 *
 * final class FlowbiteTheme implements ThemeInterface
 * {
 *     public function getName(): string
 *     {
 *         return 'flowbite';
 *     }
 *
 *     public function getRecipes(ComponentContext $context): iterable
 *     {
 *         yield new Recipe('flowbite.button', new Cookbook(new Call('class', 'btn-primary')));
 *     }
 * }
 * ```
 */
interface ThemeInterface
{
    /**
     * Returns the stable theme identifier used in diagnostics and as the conventional recipe-name prefix.
     *
     * Usage example:
     * ```php
     * public function getName(): string
     * {
     *     return 'flowbite';
     * }
     * ```
     *
     * @return string Stable theme identifier.
     */
    public function getName(): string;

    /**
     * Returns recipes in the order in which they must be applied.
     *
     * Usage example:
     * ```php
     * public function getRecipes(\UIAwesome\Html\Core\Config\ComponentContext $context): iterable
     * {
     *     $cookbook = new \UIAwesome\Html\Core\Config\Cookbook(
     *         new \UIAwesome\Html\Core\Config\Call('class', 'btn-primary'),
     *     );
     *
     *     yield new \UIAwesome\Html\Core\Config\Recipe('flowbite.button', $cookbook);
     * }
     * ```
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return iterable<Recipe>
     */
    public function getRecipes(ComponentContext $context): iterable;
}
