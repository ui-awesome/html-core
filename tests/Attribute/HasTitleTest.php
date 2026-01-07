<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use Stringable;
use UIAwesome\Html\Core\Attribute\HasTitle;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\TitleProvider;
use UIAwesome\Html\Helper\Attributes;
use UIAwesome\Html\Mixin\HasAttributes;
use UnitEnum;

/**
 * Test suite for {@see HasTitle} trait functionality and behavior.
 *
 * Validates the management of the global HTML `title` attribute according to the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of the `title` attribute in tag rendering, supporting string,
 * UnitEnum, and `null` for dynamic title assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `title` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `title` attribute.
 * - Proper assignment and overriding of `title` value.
 *
 * {@see TitleProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasTitleTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(TitleProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithTitleAttribute(
        string|Stringable|UnitEnum|null $title,
        array $attributes,
        string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasTitle;
        };

        $instance = $instance->attributes($attributes)->title($title);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenTitleAttributeNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasTitle;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingTitleAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasTitle;
        };

        self::assertNotSame(
            $instance,
            $instance->title(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(TitleProvider::class, 'values')]
    public function testSetTitleAttributeValue(
        string|Stringable|UnitEnum|null $title,
        array $attributes,
        string|Stringable|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasTitle;
        };

        $instance = $instance->attributes($attributes)->title($title);

        self::assertSame(
            $expected,
            $instance->getAttributes()['title'] ?? '',
            $message,
        );
    }
}
