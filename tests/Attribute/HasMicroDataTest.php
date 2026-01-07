<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasMicroData;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\{
    ItemIdProvider,
    ItemPropProvider,
    ItemRefProvider,
    ItemScopeProvider,
    ItemTypeProvider,
};
use UIAwesome\Html\Helper\Attributes;
use UIAwesome\Html\Mixin\HasAttributes;

/**
 * Test suite for {@see HasMicroData} trait functionality and behavior.
 *
 * Validates the management of the global HTML microdata attributes (`itemid`, `itemprop`, `itemref`, `itemscope`,
 * `itemtype`) according to the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of the microdata attributes in tag rendering, supporting bool,
 * string and `null` for dynamic assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the microdata attributes.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the microdata attributes.
 * - Proper assignment and overriding of microdata value.
 *
 * {@see ItemIdProvider}, {@see ItemPropProvider}, {@see ItemRefProvider}, {@see ItemScopeProvider},
 * {@see ItemTypeProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasMicroDataTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemIdProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithItemIdAttribute(
        string|null $itemId,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemId($itemId);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemPropProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithItemPropAttribute(
        string|null $itemProp,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemProp($itemProp);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemRefProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithItemRefAttribute(
        string|null $itemRef,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemRef($itemRef);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemScopeProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithItemScopeAttribute(
        bool|null $itemScope,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemScope($itemScope);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemTypeProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithItemTypeAttribute(
        string|null $itemType,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemType($itemType);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenMicroDataNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingItemIdAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        self::assertNotSame(
            $instance,
            $instance->itemId(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    public function testReturnNewInstanceWhenSettingItemPropAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        self::assertNotSame(
            $instance,
            $instance->itemProp(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    public function testReturnNewInstanceWhenSettingItemRefAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        self::assertNotSame(
            $instance,
            $instance->itemRef(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    public function testReturnNewInstanceWhenSettingItemScopeAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        self::assertNotSame(
            $instance,
            $instance->itemScope(false),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    public function testReturnNewInstanceWhenSettingItemTypeAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        self::assertNotSame(
            $instance,
            $instance->itemType(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemIdProvider::class, 'values')]
    public function testSetItemIdAttributeValue(
        string|null $itemId,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemId($itemId);

        self::assertSame(
            $expected,
            $instance->getAttributes()['itemid'] ?? '',
            $message,
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemPropProvider::class, 'values')]
    public function testSetItemPropAttributeValue(
        string|null $itemProp,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemProp($itemProp);

        self::assertSame(
            $expected,
            $instance->getAttributes()['itemprop'] ?? '',
            $message,
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemRefProvider::class, 'values')]
    public function testSetItemRefAttributeValue(
        string|null $itemRef,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemRef($itemRef);

        self::assertSame(
            $expected,
            $instance->getAttributes()['itemref'] ?? '',
            $message,
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemScopeProvider::class, 'values')]
    public function testSetItemScopeAttributeValue(
        bool|null $itemScope,
        array $attributes,
        bool|string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemScope($itemScope);

        self::assertSame(
            $expected,
            $instance->getAttributes()['itemscope'] ?? '',
            $message,
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(ItemTypeProvider::class, 'values')]
    public function testSetItemTypeAttributeValue(
        string|null $itemType,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasMicroData;
        };

        $instance = $instance->attributes($attributes)->itemType($itemType);

        self::assertSame(
            $expected,
            $instance->getAttributes()['itemtype'] ?? '',
            $message,
        );
    }
}
