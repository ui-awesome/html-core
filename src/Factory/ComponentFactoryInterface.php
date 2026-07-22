<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Factory;

use UIAwesome\Html\Core\Config\ComponentContext;

/**
 * Creates components from semantic config contexts.
 *
 * Usage example:
 * ```php
 * use UIAwesome\Html\Core\Config\ComponentContext;
 * use UIAwesome\Html\Core\Factory\ComponentFactoryInterface;
 *
 * final class ButtonFactory implements ComponentFactoryInterface
 * {
 *     public function create(ComponentContext $context): object
 *     {
 *         return new \App\Html\Button();
 *     }
 * }
 * ```
 */
interface ComponentFactoryInterface
{
    /**
     * Creates the component represented by the supplied context.
     *
     * Usage example:
     * ```php
     * public function create(\UIAwesome\Html\Core\Config\ComponentContext $context): object
     * {
     *     return new \App\Html\Button();
     * }
     * ```
     *
     * @param ComponentContext $context Semantic component context.
     *
     * @return object Created component instance.
     */
    public function create(ComponentContext $context): object;
}
