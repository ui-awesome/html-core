<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasSpellcheck;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\SpellcheckProvider;
use UIAwesome\Html\Helper\Attributes;

/**
 * Test suite for {@see HasSpellcheck} trait functionality and behavior.
 *
 * Validates the management of the global HTML `spellcheck` attribute according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the `spellcheck` attribute in tag rendering, supporting
 * bool, string, and `null` for dynamic spellcheck state assignment.
 *
 * Test coverage:
 * - Accurate rendering of attributes with the `spellcheck` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `spellcheck` attribute.
 * - Proper assignment and overriding of `spellcheck` value.
 *
 * {@see SpellcheckProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasSpellcheckTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(SpellcheckProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithSpellcheckAttribute(
        bool|string|null $spellcheck,
        array $attributes,
        bool|string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasSpellcheck;
        };

        $instance = $instance->attributes($attributes)->spellcheck($spellcheck);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenSpellcheckAttributeNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasSpellcheck;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingSpellcheckAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasSpellcheck;
        };

        self::assertNotSame(
            $instance,
            $instance->spellcheck(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(SpellcheckProvider::class, 'values')]
    public function testSetSpellcheckAttributeValue(
        bool|string|null $spellcheck,
        array $attributes,
        bool|string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasSpellcheck;
        };

        $instance = $instance->attributes($attributes)->spellcheck($spellcheck);

        self::assertSame(
            $expected,
            $instance->getAttributes()['spellcheck'] ?? '',
            $message,
        );
    }

    public function testThrowExceptionWhenSettingInvalidSpellcheckValue(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasSpellcheck;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                'spellcheck',
                implode('\', \'', ['false', 'true']),
            ),
        );

        $instance->spellcheck('invalid-value');
    }
}
