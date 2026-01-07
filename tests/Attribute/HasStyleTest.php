<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Core\Attribute\HasStyle;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\StyleProvider;
use UIAwesome\Html\Helper\Attributes;
use UIAwesome\Html\Mixin\HasAttributes;
use UnitEnum;

/**
 * Test suite for {@see HasStyle} trait functionality and behavior.
 *
 * Validates the management of the global HTML `style` attribute according to the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of the `style` attribute in tag rendering, supporting string,
 * UnitEnum, and null for dynamic style assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `style` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `style` attribute.
 * - Proper assignment and overriding of `style` value.
 *
 * {@see StyleProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasStyleTest extends TestCase
{
    /**
     * @phpstan-param mixed[]|string|Stringable|UnitEnum|null $style
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(StyleProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithStyleAttribute(
        array|string|Stringable|UnitEnum|null $style,
        array $attributes,
        string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasStyle;
        };

        $instance = $instance->attributes($attributes)->style($style);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenStyleAttributeNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasStyle;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingStyleAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasStyle;
        };

        self::assertNotSame(
            $instance,
            $instance->style(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[]|string|Stringable|UnitEnum|null $style
     * @phpstan-param mixed[] $attributes
     * @phpstan-param mixed[]|string|Stringable|UnitEnum $expected
     */
    #[DataProviderExternal(StyleProvider::class, 'values')]
    public function testSetStyleAttributeValue(
        array|string|Stringable|UnitEnum|null $style,
        array $attributes,
        array|string|Stringable|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasStyle;
        };

        $instance = $instance->attributes($attributes)->style($style);

        self::assertSame(
            $expected,
            $instance->getAttributes()['style'] ?? '',
            $message,
        );
    }
}
