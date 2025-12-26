<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasContentEditable;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\ContentEditableProvider;
use UIAwesome\Html\Core\Values\ContentEditable;
use UIAwesome\Html\Helper\{Attributes, Enum};
use UIAwesome\Html\Helper\Exception\Message;
use UnitEnum;

/**
 * Test suite for {@see HasContentEditable} trait functionality and behavior.
 *
 * Validates the management of the global HTML `contenteditable` attribute according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the `contenteditable` attribute in tag rendering,
 * supporting bool, string, UnitEnum, and `null` for dynamic content editable state assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `contenteditable` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `contenteditable` attribute.
 * - Proper assignment and overriding of `contenteditable` value.
 *
 * {@see ContentEditableProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasContentEditableTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ContentEditableProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithContentEditableAttribute(
        bool|string|UnitEnum|null $contenteditable,
        array $attributes,
        bool|string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasContentEditable;
        };

        $instance = $instance->attributes($attributes)->contentEditable($contenteditable);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenContentEditableAttributeNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasContentEditable;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingContentEditableAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasContentEditable;
        };

        self::assertNotSame(
            $instance,
            $instance->contentEditable(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ContentEditableProvider::class, 'values')]
    public function testSetContentEditableAttributeValue(
        bool|string|UnitEnum|null $contenteditable,
        array $attributes,
        bool|string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasContentEditable;
        };

        $instance = $instance->attributes($attributes)->contentEditable($contenteditable);

        self::assertSame(
            $expected,
            $instance->getAttributes()['contenteditable'] ?? '',
            $message,
        );
    }

    public function testThrowExceptionWhenSettingInvalidContentEditableValue(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasContentEditable;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                'contenteditable',
                implode('\', \'', Enum::normalizeArray(ContentEditable::cases())),
            ),
        );

        $instance->contentEditable('invalid-value');
    }
}
