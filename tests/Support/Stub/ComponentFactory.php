<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use stdClass;
use UIAwesome\Html\Core\Config\ComponentContext;
use UIAwesome\Html\Core\Factory\ComponentFactoryInterface;

/**
 * Component factory stub for config tests.
 */
final class ComponentFactory implements ComponentFactoryInterface
{
    public object|null $component = null;
    public ComponentContext|null $context = null;

    public function create(ComponentContext $context): stdClass
    {
        $this->context = $context;
        $this->component = new stdClass();

        return $this->component;
    }
}
