<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasLang;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\LangProvider;
use UIAwesome\Html\Core\Values\Language;
use UIAwesome\Html\Helper\{Attributes, Enum};
use UnitEnum;

/**
 * Test suite for {@see HasLang} trait functionality and behavior.
 *
 * Validates the management of the global HTML `lang` attribute according to the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of the `lang` attribute in tag rendering, supporting string,
 * UnitEnum, and `null` for dynamic language assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with the `lang` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `lang` attribute.
 * - Proper assignment and overriding of `lang` value.
 *
 * {@see LangProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasLangTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(LangProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithLangAttribute(
        string|UnitEnum|null $lang,
        array $attributes,
        string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasLang;
        };

        $instance = $instance->attributes($attributes)->lang($lang);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenLangAttributeNotSet(): void
    {
        $instance =  new class {
            use HasAttributes;
            use HasLang;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingLangAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasLang;
        };

        self::assertNotSame(
            $instance,
            $instance->lang(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(LangProvider::class, 'values')]
    public function testSetLangAttributeValue(
        string|UnitEnum|null $lang,
        array $attributes,
        string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasLang;
        };

        $instance = $instance->attributes($attributes)->lang($lang);

        self::assertSame(
            $expected,
            $instance->getAttributes()['lang'] ?? '',
            $message,
        );
    }

    public function testThrowExceptionWhenSettingInvalidLangValue(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasLang;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                'lang',
                implode('\', \'', Enum::normalizeArray(Language::cases())),
            ),
        );

        $instance->lang('invalid-value');
    }
}
