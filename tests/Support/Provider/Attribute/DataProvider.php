<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use Stringable;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\ButtonSize;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\Priority;
use UIAwesome\Html\Core\Values\DataProperty;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasDataTest} class.
 *
 * Supplies comprehensive test data for validating the handling of HTML `data-*` attributes in tag rendering, ensuring
 * standards-compliant attribute generation, key normalization, override behavior, and value propagation.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing `data-*` attributes, supporting bool,
 * scalar, UnitEnum, and deferred evaluation via \Closure, to maintain consistent output across different rendering
 * configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of `data-*` attributes in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of bool, string (including empty strings), int, float, array, UnitEnum, \Closure, and `null` handling
 *   for `data-*` attributes, including hyphenated keys and unset scenarios.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class DataProvider
{
    /**
     * Provides test cases for invalid HTML `data-*` attribute keys.
     *
     * Supplies test data for validating exception handling when setting HTML `data-*` attributes with invalid keys,
     * including empty string and non-string types.
     *
     * Each test case includes the invalid key input.
     *
     * @return array Test data for invalid `data-*` attribute keys.
     *
     * @phpstan-return array<string, array{mixed[]}>
     */
    public static function invalidKey(): array
    {
        return [
            'boolean false' => [
                [false => 'value'],
            ],
            'boolean true' => [
                [true => 'value'],
            ],
            'empty string' => [
                ['' => 'value'],
            ],
            'integer' => [
                [1 => 'value'],
            ],
        ];
    }

    /**
     * Provides test cases for invalid single HTML `data-*` attribute keys.
     *
     * Supplies test data for validating exception handling when setting a single HTML `data-*` attribute with an
     * invalid key, including empty string and UnitEnum.
     *
     * Each test case includes the invalid key and value input.
     *
     * @return array Test data for invalid single `data-*` attribute keys.
     *
     * @phpstan-return array<string, array{scalar|UnitEnum|null, string}>
     */
    public static function invalidSingleKey(): array
    {
        return [
            'empty string' => [
                '',
                'value',
            ],
            'enum key' => [
                Priority::HIGH,
                'value',
            ],
        ];
    }

    /**
     * Provides test cases for rendered HTML `data-*` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of HTML `data-*` attributes, including
     * scalar, array rendered as JSON, Stringable, UnitEnum, \Closure and without `data-` prefix in keys.
     *
     * Each test case includes the input value, the initial attributes, the override flag, the expected rendered output,
     * and an assertion message for clear identification.
     *
     * @return array Test data for rendered `data-*` attribute scenarios.
     *
     * @phpstan-return array<string, array{mixed[], mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'boolean false' => [
                ['data-value' => static fn(): bool => false],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                ['data-value' => static fn(): bool => true],
                [],
                ' data-value',
                'Should return the attribute value after setting it.',
            ],
            'closure with array' => [
                ['data-value' => static fn(): array => ['key' => 'value']],
                [],
                ' data-value=\'{"key":"value"}\'',
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean (false)' => [
                ['data-value' => static fn(): bool => false],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean (true)' => [
                ['data-value' => static fn(): bool => true],
                [],
                ' data-value',
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                ['data-value' => static fn(): string => ''],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                ['data-value' => static fn(): ButtonSize => ButtonSize::SMALL],
                [],
                ' data-value="sm"',
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                ['data-value' => static fn(): float => 0.42],
                [],
                ' data-value="0.42"',
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                ['data-value' => static fn(): int => 42],
                [],
                ' data-value="42"',
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                ['data-value' => static fn(): null|string => null],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with string' => [
                ['data-value' => static fn(): string => 'action'],
                [],
                ' data-value="action"',
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['data-value' => ''],
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum value' => [
                ['data-size' => ButtonSize::SMALL],
                [],
                ' data-size="sm"',
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                ['data-value' => 0.42],
                [],
                ' data-value="0.42"',
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                ['data-custom-action' => 'value'],
                [],
                ' data-custom-action="value"',
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                ['data-value' => 42],
                [],
                ' data-value="42"',
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'data-action' => 'action',
                    'data-callback' => static fn(): string => 'callback',
                ],
                [],
                ' data-action="action" data-callback="callback"',
                "Should set multiple 'data' attributes with mixed string and closure values.",
            ],
            'string' => [
                ['data-action' => 'action'],
                [],
                ' data-action="action"',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                [
                    'data-value' => new class implements Stringable {
                        public function __toString(): string
                        {
                            return 'stringable-value';
                        }
                    },
                ],
                [],
                ' data-value="stringable-value"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                ['data-value' => null],
                [],
                '',
                "Should unset the 'data-value' attribute when 'null' is provided after a value.",
            ],
            'without data prefix' => [
                ['value' => 'test'],
                [],
                ' data-value="test"',
                "Should normalize the key by adding 'data-' prefix if missing.",
            ],
        ];
    }

    /**
     * Provides test cases for single HTML `data-*` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of a single HTML `data-*` attribute,
     * including string keys, enum-based keys via UnitEnum, and values provided as scalars, Stringable, UnitEnum,
     * \Closure, `null` and without `data-` prefix in keys.
     *
     * Each test case includes the attribute key, the input value, the expected attributes array, and an assertion
     * message for clear identification.
     *
     * @return array Test data for single `data-*` attribute scenarios.
     *
     * @phpstan-return array<
     *   string,
     *   array{string|UnitEnum, scalar|Stringable|UnitEnum|null|\Closure(): mixed, mixed[], string},
     * >
     */
    public static function value(): array
    {
        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'stringable-value';
            }
        };

        return [
            'boolean false' => [
                'data-value',
                false,
                ['data-value' => false],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                'data-value',
                true,
                ['data-value' => true],
                'Should return the attribute value after setting it.',
            ],
            'closure with array' => [
                'data-value',
                static fn(): array => ['key' => 'value'],
                ['data-value' => ['key' => 'value']],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean false' => [
                'data-value',
                static fn(): bool => false,
                ['data-value' => false],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean true' => [
                'data-value',
                static fn(): bool => true,
                ['data-value' => true],
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                'data-value',
                static fn(): string => '',
                ['data-value' => ''],
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                'data-value',
                static fn(): ButtonSize => ButtonSize::SMALL,
                ['data-value' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                'data-value',
                static fn(): float => 0.42,
                ['data-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                'data-value',
                static fn(): int => 42,
                ['data-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                'data-value',
                static fn(): null|string => null,
                [],
                'Should return the attribute value after setting it.',
            ],
            'closure with string' => [
                'data-value',
                static fn(): string => 'Close',
                ['data-value' => 'Close'],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                'data-value',
                '',
                ['data-value' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'enum key' => [
                DataProperty::ACTION,
                'action',
                ['data-action' => 'action'],
                'Should return the attribute value after setting it.',
            ],
            'enum value' => [
                'data-size',
                ButtonSize::SMALL,
                ['data-size' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                'data-value',
                0.42,
                ['data-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                'data-custom-action',
                'value',
                ['data-custom-action' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                'data-value',
                42,
                ['data-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'string' => [
                'data-action',
                'action',
                ['data-action' => 'action'],
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                'data-value',
                $stringable,
                ['data-value' => $stringable],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                'value',
                null,
                [],
                "Should unset the 'data-value' attribute when 'null' is provided after a value.",
            ],
            'without data prefix' => [
                'value',
                'test',
                ['data-value' => 'test'],
                "Should normalize the key by adding 'data-' prefix if missing.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `data-*` attribute map scenarios.
     *
     * Supplies test data for validating bulk assignment, normalization, and removal of HTML `data-*` attributes,
     * ensuring consistent key prefixing (`data-`), hyphenated key handling, and value propagation for scalars,
     * Stringable, UnitEnum, \Closure, `null` and without `data-` prefix in keys.
     *
     * Each test case includes the input value, the expected normalized attributes array, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `data-*` attribute map scenarios.
     *
     * @phpstan-return array<string, array{mixed[], mixed[], string}>
     */
    public static function values(): array
    {
        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'stringable-value';
            }
        };

        $enumCases = [];

        foreach (DataProperty::cases() as $case) {
            $enumCases[$case->value] = [
                [$case->value => 'value'],
                ["data-{$case->value}" => 'value'],
                'Should return the attribute value after setting it.',
            ];
        }

        $staticCases = [
            'boolean false' => [
                ['data-value' => false],
                ['data-value' => false],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                ['data-value' => true],
                ['data-value' => true],
                'Should return the attribute value after setting it.',
            ],
            'closure with array' => [
                ['data-value' => static fn(): array => ['key' => 'value']],
                ['data-value' => ['key' => 'value']],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean false' => [
                ['data-value' => static fn(): bool => false],
                ['data-value' => false],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean true' => [
                ['data-value' => static fn(): bool => true],
                ['data-value' => true],
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                ['data-value' => static fn(): string => ''],
                ['data-value' => ''],
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                ['data-value' => static fn(): ButtonSize => ButtonSize::SMALL],
                ['data-value' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                ['data-value' => static fn(): float => 0.42],
                ['data-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                ['data-value' => static fn(): int => 42],
                ['data-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                ['data-value' => static fn(): null|string => null],
                [],
                'Should return the attribute value after setting it.',
            ],
            'closure with string' => [
                ['data-value' => static fn(): string => 'Close'],
                ['data-value' => 'Close'],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['data-value' => ''],
                ['data-value' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'enum value' => [
                ['data-size' => ButtonSize::SMALL],
                ['data-size' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                ['data-value' => 0.42],
                ['data-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                ['data-custom-action' => 'value'],
                ['data-custom-action' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                ['data-value' => 42],
                ['data-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'data-action' => 'action',
                    'data-callback' => static fn(): string => 'action',
                ],
                [
                    'data-action' => 'action',
                    'data-callback' => 'action',
                ],
                "Should set multiple 'data' attributes with mixed string and closure values.",
            ],
            'string' => [
                ['data-action' => 'action'],
                ['data-action' => 'action'],
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                ['data-value' => $stringable],
                ['data-value' => $stringable],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                ['data-value' => null],
                [],
                "Should unset the 'data-value' attribute when 'null' is provided after a value.",
            ],
            'without data prefix' => [
                ['value' => 'test'],
                ['data-value' => 'test'],
                "Should normalize the key by adding 'data-' prefix if missing.",
            ],
        ];

        return [...$staticCases, ...$enumCases];
    }
}
