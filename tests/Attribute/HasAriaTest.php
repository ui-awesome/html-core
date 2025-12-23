<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use Closure;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use stdClass;
use Stringable;
use UIAwesome\Html\Core\Attribute\HasAria;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\AriaProvider;
use UIAwesome\Html\Helper\Attributes;
use UnitEnum;

/**
 * Test suite for {@see HasAria} trait functionality and behavior.
 *
 * Validates the management of global HTML `aria-*` attributes according to the WAI-ARIA specification.
 *
 * Ensures correct handling, immutability, and validation of `aria-*` attributes in tag rendering, supporting scalar,
 * Stringable, UnitEnum, and Closure for dynamic attribute assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with `aria-*` attributes.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Exception handling for invalid keys and values.
 * - Immutability of the trait's API when setting or overriding `aria-*` attributes.
 * - Proper assignment and overriding of `aria-*` attribute values.
 *
 * {@see AriaProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasAriaTest extends TestCase
{
    /**
     * @param mixed[] $data
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(AriaProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithAriaAttribute(
        array $data,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAria;
            use HasAttributes;
        };

        $instance = $instance->attributes($attributes)->ariaAttributes($data);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenAriaAttributeNotSet(): void
    {
        $instance = new class {
            use HasAria;
            use HasAttributes;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingAriaAttribute(): void
    {
        $instance = new class {
            use HasAria;
            use HasAttributes;
        };

        self::assertNotSame(
            $instance,
            $instance->addAriaAttribute('pressed', true),
            'Should return a new instance when adding the attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->ariaAttributes(['pressed' => true]),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeAriaAttribute('pressed'),
            'Should return a new instance when removing the attribute, ensuring immutability.',
        );
    }

    /**
     * @param mixed[] $data
     * @param mixed[] $expected
     */
    #[DataProviderExternal(AriaProvider::class, 'values')]
    public function testSetAriaAttributeValue(array $data, array $expected, string $message): void
    {
        $instance = new class {
            use HasAria;
            use HasAttributes;
        };

        $instance = $instance->ariaAttributes($data);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    /**
     * @phpstan-param scalar|Stringable|UnitEnum|null|Closure(): mixed $value
     * @phpstan-param mixed[] $expected
     */
    #[DataProviderExternal(AriaProvider::class, 'value')]
    public function testSetSingleAriaAttributeValue(
        string|UnitEnum $key,
        bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
        array $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAria;
            use HasAttributes;
        };

        $instance = $instance->addAriaAttribute($key, $value);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    public function testThrowInvalidArgumentExceptionWhenAriaAttributeValueIsInvalid(): void
    {
        $instance = new class {
            use HasAria;
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::ATTRIBUTE_VALUE_MUST_BE_SCALAR_OR_CLOSURE->getMessage('object'),
        );

        $instance->ariaAttributes(['key' => new stdClass()]);
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(AriaProvider::class, 'invalidKey')]
    public function testThrowInvalidArgumentExceptionWhenSetAriaAttributeKeyIsInvalid(array $attributes): void
    {
        $instance = new class {
            use HasAria;
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(),
        );

        $instance->ariaAttributes($attributes);
    }

    #[DataProviderExternal(AriaProvider::class, 'invalidSingleKey')]
    public function testThrowInvalidArgumentExceptionWhenSetSingleAriaAttributeKeyIsInvalid(
        string|UnitEnum $key,
        string $value,
    ): void {
        $instance = new class {
            use HasAria;
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(),
        );

        $instance->addAriaAttribute($key, $value);
    }
}
