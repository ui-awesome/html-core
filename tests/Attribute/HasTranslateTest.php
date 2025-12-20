<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasTranslate;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\TranslateProvider;
use UIAwesome\Html\Core\Values\Translate;
use UIAwesome\Html\Helper\{Attributes, Enum};
use UIAwesome\Html\Helper\Exception\Message;
use UnitEnum;

/**
 * Test suite for {@see HasTranslate} trait functionality and behavior.
 *
 * Validates the management of the global HTML `translate` attribute according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the `translate` attribute in tag rendering, supporting
 * bool, string, UnitEnum, and `null` for dynamic translate state assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `translate` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `translate` attribute.
 * - Proper assignment and overriding of `translate` value.
 *
 * {@see TranslateProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasTranslateTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(TranslateProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithTranslateAttribute(
        bool|string|UnitEnum|null $translate,
        array $attributes,
        bool|string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasTranslate;
        };

        $instance = $instance->attributes($attributes)->translate($translate);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenTranslateAttributeNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasTranslate;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingTranslateAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasTranslate;
        };

        self::assertNotSame(
            $instance,
            $instance->translate(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(TranslateProvider::class, 'values')]
    public function testSetTranslateAttributeValue(
        bool|string|UnitEnum|null $translate,
        array $attributes,
        bool|string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasTranslate;
        };

        $instance = $instance->attributes($attributes)->translate($translate);

        self::assertSame(
            $expected,
            $instance->getAttributes()['translate'] ?? '',
            $message,
        );
    }

    public function testThrowExceptionWhenSettingInvalidTranslateValue(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasTranslate;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                'translate',
                implode('\', \'', Enum::normalizeArray(Translate::cases())),
            ),
        );

        $instance->translate('invalid-value');
    }
}
