<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasId;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\IdProvider;
use UIAwesome\Html\Helper\Attributes;

/**
 * Test suite for {@see HasId} trait functionality and behavior.
 *
 * Validates the management of the global HTML `id` attribute according to the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of the `id` attribute in tag rendering, supporting both string
 * and `null` for dynamic identifier assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `id` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `id` attribute.
 * - Proper assignment and overriding of `id` value.
 *
 * {@see IdProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasIdTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(IdProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithIdAttribute(
        string|null $id,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasId;
        };

        $instance = $instance->attributes($attributes)->id($id);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenIdAttributeNotSet(): void
    {
        $instance =  new class {
            use HasAttributes;
            use HasId;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingIdAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasId;
        };

        self::assertNotSame(
            $instance,
            $instance->id(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(IdProvider::class, 'values')]
    public function testSetIdAttributeValue(
        string|null $id,
        array $attributes,
        string|null $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasId;
        };

        $instance = $instance->attributes($attributes)->id($id);

        self::assertSame(
            $expected,
            $instance->getAttributes()['id'] ?? '',
            $message,
        );
    }
}
