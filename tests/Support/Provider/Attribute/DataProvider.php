<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use Stringable;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\ButtonSize;
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
     * Provides test cases for rendered HTML `data-*` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of HTML `data-*` attributes,
     * including scalar, array rendered as JSON, Stringable, UnitEnum, and deferred evaluation via \Closure.
     *
     * Each test case includes the input `data`, the initial attributes, the expected rendered output, and an
     * assertion message for clear identification.
     *
     * @return array Test data for rendered `data-*` attribute scenarios.
     *
     * @phpstan-return array<string, array{mixed[], mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'boolean false' => [
                ['value' => static fn(): bool => false],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                ['value' => static fn(): bool => true],
                [],
                ' data-value',
                'Should return the attribute value after setting it.',
            ],
            'closure with array' => [
                ['value' => static fn(): array => ['key' => 'value']],
                [],
                ' data-value=\'{"key":"value"}\'',
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean (false)' => [
                ['value' => static fn(): bool => false],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean (true)' => [
                ['value' => static fn(): bool => true],
                [],
                ' data-value',
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                ['value' => static fn(): string => ''],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                ['value' => static fn(): ButtonSize => ButtonSize::SMALL],
                [],
                ' data-value="sm"',
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                ['value' => static fn(): float => 0.42],
                [],
                ' data-value="0.42"',
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                ['value' => static fn(): int => 42],
                [],
                ' data-value="42"',
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                ['value' => static fn(): null|string => null],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with string' => [
                ['value' => static fn(): string => 'action'],
                [],
                ' data-value="action"',
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['value' => ''],
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum value' => [
                ['size' => ButtonSize::SMALL],
                [],
                ' data-size="sm"',
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                ['value' => 0.42],
                [],
                ' data-value="0.42"',
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                ['custom-action' => 'value'],
                [],
                ' data-custom-action="value"',
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                ['value' => 42],
                [],
                ' data-value="42"',
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'action' => 'action',
                    'callback' => static fn(): string => 'callback',
                ],
                [],
                ' data-action="action" data-callback="callback"',
                "Should set multiple 'data' attributes with mixed string and closure values.",
            ],
            'multiple string' => [
                [
                    'action' => 'action',
                    'id' => 'id',
                    'value' => 'value',
                ],
                [],
                ' data-action="action" data-id="id" data-value="value"',
                "Should set multiple 'data' attributes with string values.",
            ],
            'string' => [
                ['action' => 'action'],
                [],
                ' data-action="action"',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                [
                    'value' => new class implements Stringable {
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
                ['value' => null],
                [],
                '',
                "Should unset the 'data-value' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for single HTML `data-*` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of a single HTML `data-*` attribute,
     * including string keys, enum-based keys via UnitEnum, and values provided as scalars, Stringable, UnitEnum,
     * \Closure, and `null`.
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
        $closure = static fn(): string => 'action';
        $stringable = new class {
            public function __toString(): string
            {
                return 'stringable-value';
            }
        };

        return [
            'boolean false' => [
                'value',
                false,
                ['data-value' => false],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                'value',
                true,
                ['data-value' => true],
                'Should return the attribute value after setting it.',
            ],
            'closure' => [
                'value',
                $closure,
                ['data-value' => $closure],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                'value',
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
                'size',
                ButtonSize::SMALL,
                ['data-size' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                'custom-action',
                'value',
                ['data-custom-action' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'string' => [
                'action',
                'action',
                ['data-action' => 'action'],
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                'value',
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
        ];
    }

    /**
     * Provides test cases for HTML `data-*` attribute map scenarios.
     *
     * Supplies test data for validating bulk assignment, normalization, and removal of HTML `data-*` attributes,
     * ensuring consistent key prefixing (`data-`), hyphenated key handling, and value propagation for scalars,
     * Stringable, UnitEnum, \Closure, and `null`.
     *
     * Each test case includes the input value map, the expected normalized attributes array, and an assertion message
     * for clear identification.
     *
     * @return array Test data for `data-*` attribute map scenarios.
     *
     * @phpstan-return array<string, array{mixed[], mixed[], string}>
     */
    public static function values(): array
    {
        $closure = static fn(): string => 'action';
        $stringable = new class {
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
                ['value' => false],
                ['data-value' => false],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                ['value' => true],
                ['data-value' => true],
                'Should return the attribute value after setting it.',
            ],
            'closure' => [
                ['value' => $closure],
                ['data-value' => $closure],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['value' => ''],
                ['data-value' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'enum value' => [
                ['size' => ButtonSize::SMALL],
                ['data-size' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                ['value' => 0.42],
                ['data-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                ['custom-action' => 'value'],
                ['data-custom-action' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                ['value' => 42],
                ['data-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'action' => 'action',
                    'callback' => $closure,
                ],
                [
                    'data-action' => 'action',
                    'data-callback' => $closure,
                ],
                "Should set multiple 'data' attributes with mixed string and closure values.",
            ],
            'multiple string' => [
                [
                    'action' => 'action',
                    'id' => 'id',
                    'value' => 'value',
                ],
                [
                    'data-action' => 'action',
                    'data-id' => 'id',
                    'data-value' => 'value',
                ],
                "Should set multiple 'data' attributes with string values.",
            ],
            'string' => [
                ['action' => 'action'],
                ['data-action' => 'action'],
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                ['value' => $stringable],
                ['data-value' => $stringable],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                [
                    'value' => null,
                ],
                [],
                "Should unset the 'data-value' attribute when 'null' is provided after a value.",
            ],
        ];

        return [...$staticCases, ...$enumCases];
    }
}
