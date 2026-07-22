<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use LogicException;
use stdClass;

/**
 * Fluent component stub for config applier tests.
 *
 * Intentionally not `final`: {@see ExtendedComponent} extends it to exercise subclass return acceptance.
 */
class ConfigurableComponent
{
    /**
     * @var list<string>
     */
    public array $values = [];

    public function append(string $value): static
    {
        $component = clone $this;
        $component->values[] = $value;

        return $component;
    }

    public function appendPair(string $prefix, string $suffix, string $separator): static
    {
        $component = clone $this;
        $component->values[] = $prefix . $separator . $suffix;

        return $component;
    }

    public function fail(): self
    {
        throw new LogicException('Component call failed.');
    }

    public function returnOtherComponent(): stdClass
    {
        return new stdClass();
    }

    public function returnScalar(): string
    {
        return 'invalid';
    }

    public static function staticCall(): self
    {
        return new self();
    }

    public function upgrade(): self
    {
        return new ExtendedComponent();
    }

    protected function nonPublicCall(): self
    {
        return $this;
    }
}
