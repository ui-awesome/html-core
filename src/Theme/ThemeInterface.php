<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Theme;

use UIAwesome\Html\Core\Config\{ComponentContext, Recipe};

/**
 * Resolves ordered config recipes for semantic component contexts.
 */
interface ThemeInterface
{
    /**
     * Returns the stable theme identifier used in diagnostics and as the conventional recipe-name prefix.
     *
     * @return string Stable theme identifier.
     */
    public function getName(): string;

    /**
     * Returns recipes in the order in which they must be applied.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return iterable<Recipe>
     */
    public function getRecipes(ComponentContext $context): iterable;
}
