<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use Closure;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use stdClass;
use UIAwesome\Html\Core\Attribute\HasData;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\DataProvider;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\Priority;
use UIAwesome\Html\Helper\Attributes;
use UnitEnum;

/**
 * Test suite for {@see HasData} trait functionality and behavior.
 *
 * Validates the management of the global HTML `data-*` attributes according to the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of `data-*` attributes in tag rendering, supporting both
 * string and Closure for dynamic data assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with `data-*` attributes.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Exception handling for invalid keys and values.
 * - Immutability of the trait's API when setting or overriding `data-*` attributes.
 * - Proper assignment and overriding of `data-*` value.
 *
 * {@see DataProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasDataTest extends TestCase
{
    /**
     * @param array<string, \Closure(): mixed|string> $data
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(DataProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithDataAttribute(
        array $data,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasData;
        };

        $instance = $instance->attributes($attributes)->dataAttributes($data);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnNewInstanceWhenSettingDataAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasData;
        };

        self::assertNotSame(
            $instance,
            $instance->addDataAttribute('action', 'test-action'),
            'Should return a new instance when adding the attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->dataAttributes(['action' => 'test-action']),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeDataAttribute('action'),
            'Should return a new instance when removing the attribute, ensuring immutability.',
        );
    }

    /**
     * @param array<string, \Closure(): mixed|string> $data
     * @param array<string, \Closure(): mixed|string> $expected
     */
    #[DataProviderExternal(DataProvider::class, 'values')]
    public function testSetDataAttributeValue(array $data, array $expected, string $message): void
    {
        $instance = new class {
            use HasAttributes;
            use HasData;
        };

        $instance = $instance->dataAttributes($data);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    /**
     * @phpstan-param scalar|Closure(): mixed|UnitEnum|null $value
     * @phpstan-param mixed[] $expected
     */
    #[DataProviderExternal(DataProvider::class, 'value')]
    public function testSetSingleDataAttributeValue(
        string|UnitEnum $key,
        bool|float|int|string|Closure|UnitEnum|null $value,
        array $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasData;
        };

        $instance = $instance->addDataAttribute($key, $value);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    public function testThrowInvalidArgumentExceptionWhenDataAttributeValueIsInvalid(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasData;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::DATA_ATTRIBUTE_VALUE_MUST_BE_SCALAR_OR_CLOSURE->getMessage('object'),
        );

        $instance->dataAttributes(['key' => new stdClass()]);
    }

    public function testThrowInvalidArgumentExceptionWhenSetDataAttributeKeyIsEmpty(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasData;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::DATA_ATTRIBUTE_KEY_NOT_EMPTY->getMessage(),
        );

        $instance->dataAttributes(['' => 'value']);
    }

    public function testThrowInvalidArgumentExceptionWhenSetDataAttributeKeyIsInvalid(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasData;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::DATA_ATTRIBUTE_KEY_MUST_BE_STRING->getMessage('integer'),
        );

        $instance->dataAttributes([1 => '']);
    }

    public function testThrowInvalidArgumentExceptionWhenSetSingleDataAttributeWithEmptyKey(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasData;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::DATA_ATTRIBUTE_KEY_NOT_EMPTY->getMessage(),
        );

        $instance->addDataAttribute('', 'value');
    }

    public function testThrowInvalidArgumentExceptionWhenSetSingleDataAttributeWithInvalidKey(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasData;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::DATA_ATTRIBUTE_KEY_MUST_BE_STRING->getMessage('integer'),
        );

        $instance->addDataAttribute(Priority::HIGH, 'value');
    }
}
