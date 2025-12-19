<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Mixin;

use Closure;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Mixin\AttributeProvider;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\Priority;

/**
 * Test suite for {@see HasAttributes} mixin functionality and behavior.
 *
 * Validates the management and immutability of HTML attribute handling in tag rendering, according to the HTML Living
 * Standard specification.
 *
 * Ensures correct initialization, assignment, and retrieval of attributes, supporting array-based attribute storage and
 * enforcing immutability when setting new attributes.
 *
 * Test coverage.
 * - Accurate retrieval of attributes when not set.
 * - Correct assignment and retrieval of attribute value.
 * - Immutability of the mixin when setting attributes.
 * - Removal of specific attributes from the attribute set.
 * - Setting and retrieving single attribute values.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasAttributesTest extends TestCase
{
    public function testRemoveAttributeValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(['id' => 'my-id', 'class' => 'my-class']);
        $instance = $instance->removeAttribute('id');

        self::assertSame(
            ['class' => 'my-class'],
            $instance->getAttributes(),
            'Should return the attributes array after removing an attribute.',
        );
    }

    public function testReturnEmptyArrayWhenAttributesNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertSame(
            [],
            $instance->getAttributes(),
            'Should return an empty array when no attributes are set.',
        );
    }

    public function testReturnNewInstanceWhenSettingAttributes(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertNotSame(
            $instance,
            $instance->addAttribute('key', 'value'),
            'Should return a new instance when adding an attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->attributes([]),
            'Should return a new instance when setting the attributes, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeAttribute('key'),
            'Should return a new instance when removing an attribute, ensuring immutability.',
        );
    }

    /**
     * @param array<string, \Closure(): mixed|string> $attributes
     * @param array<string, \Closure(): mixed|string> $expected
     */
    #[DataProviderExternal(AttributeProvider::class, 'values')]
    public function testSetAttributesValue(array $attributes, array $expected, string $message): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes($attributes);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    /**
     * @phpstan-param scalar|Closure(): mixed|null $value
     * @phpstan-param mixed[] $expected
     */
    #[DataProviderExternal(AttributeProvider::class, 'value')]
    public function testSetSingleAttributeValue(
        string $key,
        bool|float|int|string|Closure|null $value,
        array $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->addAttribute($key, $value);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    public function testThrowInvalidArgumentExceptionWhenSetSingleAttributeWithEmptyKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->addAttribute('', 'value');
    }

    public function testThrowInvalidArgumentExceptionWhenSetSingleAttributeWithInvalidKey(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(2),
        );

        $instance->addAttribute(Priority::HIGH, 'value');
    }
}
