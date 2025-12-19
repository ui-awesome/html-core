<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Core\Attribute\HasClass;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\ClassProvider;
use UIAwesome\Html\Helper\Attributes;
use UnitEnum;

/**
 * Test suite for {@see HasClass} trait functionality and behavior.
 *
 * Validates the management of the global HTML `class` attribute according to the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of the `class` attribute in tag rendering, supporting
 * string, UnitEnum, and `null` for dynamic class assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `class` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `class` attribute.
 * - Proper assignment and overriding of `class` value.
 *
 * {@see ClassProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasClassTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ClassProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithClassAttribute(
        string|Stringable|UnitEnum|null $cssClasses,
        array $attributes,
        bool $override,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasClass;
        };

        $instance = match ($override) {
            true => $instance->attributes($attributes)->class($cssClasses, true),
            default => $instance->attributes($attributes)->class($cssClasses),
        };

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenClassAttributeNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasClass;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingClassAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasClass;
        };

        self::assertNotSame(
            $instance,
            $instance->class(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param array<array{value: string|UnitEnum|null, override?: bool}> $operations
     */
    #[DataProviderExternal(ClassProvider::class, 'values')]
    public function testSetClassAttributeValue(array $operations, string $expected, string $message): void
    {
        $instance = new class {
            use HasAttributes;
            use HasClass;
        };

        foreach ($operations as $operation) {
            $override = $operation['override'] ?? null;

            $instance = match ($override) {
                true => $instance->class($operation['value'], true),
                default => $instance->class($operation['value']),
            };
        }

        self::assertSame(
            $expected,
            $instance->getAttributes()['class'] ?? '',
            $message,
        );
    }
}
