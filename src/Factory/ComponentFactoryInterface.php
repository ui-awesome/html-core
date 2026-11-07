<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Factory;

use UIAwesome\Html\Core\Config\ComponentContext;

/**
 * Creates components from semantic config contexts.
 */
interface ComponentFactoryInterface
{
    /**
     * Creates the component represented by the supplied context.
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return object Created component instance.
     */
    public function create(ComponentContext $context): object;
}
