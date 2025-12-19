<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\CanBeAutofocus;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\AutofocusProvider;
use UIAwesome\Html\Helper\Attributes;

/**
 * Test suite for {@see CanBeAutofocus} trait functionality and behavior.
 *
 * Validates the management of the global HTML `autofocus` attribute according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the `autofocus` attribute in tag rendering, supporting
 * bool for dynamic autofocus state assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `autofocus` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `autofocus` attribute.
 * - Proper assignment and overriding of `autofocus` value.
 *
 * {@see AutofocusProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class CanBeAutofocusTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(AutofocusProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithAutofocusAttribute(
        bool $value,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use CanBeAutofocus;
            use HasAttributes;
        };

        $instance = $instance->attributes($attributes)->autofocus($value);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenAutofocusAttributeNotSet(): void
    {
        $instance = new class {
            use CanBeAutofocus;
            use HasAttributes;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingAutofocusAttribute(): void
    {
        $instance = new class {
            use CanBeAutofocus;
            use HasAttributes;
        };

        self::assertNotSame(
            $instance,
            $instance->autofocus(true),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(AutofocusProvider::class, 'values')]
    public function testSetAutofocusAttributeValue(
        bool $value,
        array $attributes,
        bool|string $expected,
        string $message,
    ): void {
        $instance = new class {
            use CanBeAutofocus;
            use HasAttributes;
        };

        $instance = $instance->attributes($attributes)->autofocus($value);

        self::assertSame(
            $expected,
            $instance->getAttributes()['autofocus'] ?? '',
            $message,
        );
    }
}
