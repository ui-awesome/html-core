<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Config\{ComponentContext, ConfigApplierInterface, Recipe};

/**
 * Config applier stub for config tests.
 */
final class ConfigApplier implements ConfigApplierInterface
{
    public object|null $component = null;
    /**
     * @var list<ComponentContext>
     */
    public array $contexts = [];
    /**
     * @var list<string>
     */
    public array $recipes = [];
    /**
     * @var list<bool>
     */
    public array $strictModes = [];

    public function apply(
        object $component,
        Recipe $recipe,
        ComponentContext $context,
        bool $strict = true,
    ): object {
        $this->recipes[] = $recipe->name;
        $this->contexts[] = $context;
        $this->strictModes[] = $strict;

        return $this->component ?? $component;
    }
}
