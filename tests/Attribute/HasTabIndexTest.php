<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasTabindex;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\TabIndexProvider;
use UIAwesome\Html\Helper\Attributes;

/**
 * Test suite for {@see HasTabindex} trait functionality and behavior.
 *
 * Validates the management of the global HTML `tabindex` attribute according to the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of the `tabindex` attribute in tag rendering, supporting both
 * int, string, and `null` for dynamic tabindex assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `tabindex` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Exception handling for invalid values and types.
 * - Immutability of the trait's API when setting or overriding the `tabindex` attribute.
 * - Proper assignment and overriding of `tabindex` value.
 *
 * {@see TabIndexProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasTabIndexTest extends TestCase
{
    /**
     * @phpstan-param int|string|null $tabIndex
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(TabIndexProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithTabIndexAttribute(
        int|string|null $tabIndex,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasTabindex;
        };

        $instance = $instance->attributes($attributes)->tabIndex($tabIndex);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenTabIndexAttributeNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasTabindex;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingTabIndexAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasTabindex;
        };

        self::assertNotSame(
            $instance,
            $instance->tabIndex(1),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param int|string|null $tabIndex
     * @phpstan-param mixed[] $attributes
     * @phpstan-param mixed[] $expected
     */
    #[DataProviderExternal(TabIndexProvider::class, 'values')]
    public function testSetTabIndexAttributeValue(
        int|string|null $tabIndex,
        array $attributes,
        array $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasTabindex;
        };

        $instance = $instance->attributes($attributes)->tabIndex($tabIndex);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    #[DataProviderExternal(TabIndexProvider::class, 'invalidValues')]
    public function testThrowExceptionWhenSettingInvalidTabIndexAttribute(int|string $tabIndex): void
    {
        $instance = new class {
            use HasAttributes;
            use HasTabindex;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::INVALID_ATTRIBUTE_VALUE->getMessage($tabIndex, 'tabindex', 'value >= -1'),
        );

        $instance->tabIndex($tabIndex);
    }
}
