<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasAccesskey;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\AccesskeyProvider;
use UIAwesome\Html\Helper\Attributes;

/**
 * Test suite for {@see HasAccesskey} trait functionality and behavior.
 *
 * Validates the management of the global HTML `accesskey` attribute according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the `accesskey` attribute in tag rendering, supporting both
 * string and `null` for dynamic identifier assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `accesskey` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `accesskey` attribute.
 * - Proper assignment and overriding of `accesskey` value.
 *
 * {@see AccesskeyProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasAccesskeyTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(AccesskeyProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithAccesskeyAttribute(
        string|null $accesskey,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAccesskey;
            use HasAttributes;
        };

        $instance = $instance->attributes($attributes)->accesskey($accesskey);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenAccesskeyAttributeNotSet(): void
    {
        $instance = new class {
            use HasAccesskey;
            use HasAttributes;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingAccesskeyAttribute(): void
    {
        $instance = new class {
            use HasAccesskey;
            use HasAttributes;
        };

        self::assertNotSame(
            $instance,
            $instance->accesskey(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(AccesskeyProvider::class, 'values')]
    public function testSetAccesskeyAttributeValue(
        string|null $accesskey,
        array $attributes,
        string|null $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAccesskey;
            use HasAttributes;
        };

        $instance = $instance->attributes($attributes)->accesskey($accesskey);

        self::assertSame(
            $expected,
            $instance->getAttributes()['accesskey'] ?? '',
            $message,
        );
    }
}
