<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasDraggable;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\DraggableProvider;
use UIAwesome\Html\Core\Values\Draggable;
use UIAwesome\Html\Helper\{Attributes, Enum};
use UIAwesome\Html\Helper\Exception\Message;
use UIAwesome\Html\Mixin\HasAttributes;
use UnitEnum;

/**
 * Test suite for {@see HasDraggable} trait functionality and behavior.
 *
 * Validates the management of the global HTML `draggable` attribute according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the `draggable` attribute in tag rendering, supporting
 * bool, string, UnitEnum, and `null` for dynamic draggable state assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `draggable` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `draggable` attribute.
 * - Proper assignment and overriding of `draggable` value.
 *
 * {@see DraggableProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasDraggableTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(DraggableProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithDraggableAttribute(
        bool|string|UnitEnum|null $draggable,
        array $attributes,
        bool|string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasDraggable;
        };

        $instance = $instance->attributes($attributes)->draggable($draggable);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenDraggableAttributeNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasDraggable;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingDraggableAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasDraggable;
        };

        self::assertNotSame(
            $instance,
            $instance->draggable(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(DraggableProvider::class, 'values')]
    public function testSetDraggableAttributeValue(
        bool|string|UnitEnum|null $draggable,
        array $attributes,
        bool|string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasDraggable;
        };

        $instance = $instance->attributes($attributes)->draggable($draggable);

        self::assertSame(
            $expected,
            $instance->getAttributes()['draggable'] ?? '',
            $message,
        );
    }

    public function testThrowInvalidArgumentExceptionForSettingInvalidDraggableValue(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasDraggable;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                'draggable',
                implode('\', \'', Enum::normalizeArray(Draggable::cases())),
            ),
        );

        $instance->draggable('invalid-value');
    }
}
