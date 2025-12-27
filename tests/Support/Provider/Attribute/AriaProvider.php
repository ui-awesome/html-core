<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use Stringable;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\{ButtonSize, Priority};
use UIAwesome\Html\Core\Values\Aria;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasAriaTest} class.
 *
 * Supplies comprehensive test data for validating the handling of HTML `aria-*` attributes in tag rendering, ensuring
 * standards-compliant attribute generation, key normalization, override behavior, and value propagation.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing `aria-*` attributes, supporting bool,
 * scalar, UnitEnum, and deferred evaluation via \Closure, to maintain consistent output across different rendering
 * configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of `aria-*` attributes in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of bool, string (including empty strings), int, float, array, UnitEnum, \Closure, and `null` handling
 *   for `aria-*` attributes, including hyphenated keys and unset scenarios.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class AriaProvider
{
    /**
     * Provides test cases for invalid HTML `aria-*` attribute keys.
     *
     * Supplies test data for validating exception handling when setting HTML `aria-*` attributes with invalid keys,
     * including empty string and non-string types.
     *
     * Each test case includes the invalid key input.
     *
     * @return array Test data for invalid `aria-*` attribute keys.
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
     * Provides test cases for invalid single HTML `aria-*` attribute keys.
     *
     * Supplies test data for validating exception handling when setting a single HTML `aria-*` attribute with an
     * invalid key, including empty string and UnitEnum.
     *
     * Each test case includes the invalid key and value input.
     *
     * @return array Test data for invalid single `aria-*` attribute keys.
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
     * Provides test cases for rendered HTML `aria-*` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of HTML `aria-*` attributes, including
     * scalar, array rendered as JSON, Stringable, UnitEnum, \Closure and without `aria-` prefix in keys.
     *
     * Each test case includes the input value, the initial attributes, the override flag, the expected rendered output,
     * and an assertion message for clear identification.
     *
     * @return array Test data for rendered `aria-*` attribute scenarios.
     *
     * @phpstan-return array<string, array{mixed[], mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'boolean false' => [
                ['aria-pressed' => false],
                [],
                ' aria-pressed="false"',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                ['aria-pressed' => true],
                [],
                ' aria-pressed="true"',
                'Should return the attribute value after setting it.',
            ],
            'closure with array' => [
                ['aria-controls' => static fn(): array => ['key' => 'value']],
                [],
                " aria-controls='{\"key\":\"value\"}'",
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean false' => [
                ['aria-pressed' => static fn(): bool => false],
                [],
                ' aria-pressed="false"',
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean true' => [
                ['aria-pressed' => static fn(): bool => true],
                [],
                ' aria-pressed="true"',
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                ['aria-label' => static fn(): string => ''],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                ['aria-size' => static fn(): ButtonSize => ButtonSize::SMALL],
                [],
                ' aria-size="sm"',
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                ['aria-value' => static fn(): float => 0.42],
                [],
                ' aria-value="0.42"',
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                ['aria-value' => static fn(): int => 42],
                [],
                ' aria-value="42"',
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                ['aria-label' => static fn(): null|string => null],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with string' => [
                ['aria-label' => static fn(): string => 'Close'],
                [],
                ' aria-label="Close"',
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['aria-label' => ''],
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum value' => [
                ['aria-size' => ButtonSize::SMALL],
                [],
                ' aria-size="sm"',
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                ['aria-value' => 0.42],
                [],
                ' aria-value="0.42"',
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                ['aria-describedby' => 'desc'],
                [],
                ' aria-describedby="desc"',
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                ['aria-value' => 42],
                [],
                ' aria-value="42"',
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'aria-label' => 'Close',
                    'aria-controls' => static fn(): string => 'modal-1',
                ],
                [],
                ' aria-label="Close" aria-controls="modal-1"',
                "Should set multiple 'aria' attributes with mixed string and closure values.",
            ],
            'string' => [
                ['aria-label' => 'Close'],
                [],
                ' aria-label="Close"',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                [
                    'aria-label' => new class implements Stringable {
                        public function __toString(): string
                        {
                            return 'stringable-value';
                        }
                    },
                ],
                [],
                ' aria-label="stringable-value"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                ['aria-label' => null],
                [],
                '',
                "Should unset the 'aria-label' attribute when 'null' is provided after a value.",
            ],
            'without aria prefix' => [
                ['pressed' => true],
                [],
                ' aria-pressed="true"',
                'Should normalize key without aria prefix when setting the attribute.',
            ],
        ];
    }

    /**
     * Provides test cases for single HTML `aria-*` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of a single HTML `aria-*` attribute,
     * including string keys, enum-based keys via UnitEnum, and values provided as scalars, Stringable, UnitEnum,
     * \Closure, `null` and without `aria-` prefix in keys.
     *
     * Each test case includes the attribute key, the input value, the expected attributes array, and an assertion
     * message for clear identification.
     *
     * @return array Test data for single `aria-*` attribute scenarios.
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
                'aria-pressed',
                false,
                ['aria-pressed' => 'false'],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                'aria-pressed',
                true,
                ['aria-pressed' => 'true'],
                'Should return the attribute value after setting it.',
            ],
            'closure with array' => [
                'aria-controls',
                static fn(): array => ['key' => 'value'],
                ['aria-controls' => ['key' => 'value']],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean false' => [
                'aria-pressed',
                static fn(): bool => false,
                ['aria-pressed' => 'false'],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean true' => [
                'aria-pressed',
                static fn(): bool => true,
                ['aria-pressed' => 'true'],
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                'aria-label',
                static fn(): string => '',
                ['aria-label' => ''],
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                'aria-size',
                static fn(): ButtonSize => ButtonSize::SMALL,
                ['aria-size' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                'aria-value',
                static fn(): float => 0.42,
                ['aria-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                'aria-value',
                static fn(): int => 42,
                ['aria-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                'aria-label',
                static fn(): null|string => null,
                [],
                'Should return the attribute value after setting it.',
            ],
            'closure with string' => [
                'aria-label',
                static fn(): string => 'Close',
                ['aria-label' => 'Close'],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                'aria-label',
                '',
                ['aria-label' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'enum key' => [
                Aria::ATOMIC,
                'value',
                ['aria-atomic' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'enum value' => [
                'aria-size',
                ButtonSize::SMALL,
                ['aria-size' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                'aria-value',
                0.42,
                ['aria-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                'aria-describedby',
                'desc',
                ['aria-describedby' => 'desc'],
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                'aria-value',
                42,
                ['aria-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                'aria-controls',
                static fn(): string => 'modal-1',
                ['aria-controls' => 'modal-1'],
                'Should return the attribute value after setting it.',
            ],
            'string' => [
                'aria-label',
                'Close',
                ['aria-label' => 'Close'],
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                'aria-label',
                $stringable,
                ['aria-label' => $stringable],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                'aria-label',
                null,
                [],
                "Should unset the 'aria-label' attribute when 'null' is provided after a value.",
            ],
            'without aria prefix' => [
                'pressed',
                true,
                ['aria-pressed' => 'true'],
                'Should normalize key without aria prefix when setting the attribute.',
            ],
        ];
    }

    /**
     * Provides test cases for HTML `aria-*` attribute map scenarios.
     *
     * Supplies test data for validating bulk assignment, normalization, and removal of HTML `aria-*` attributes,
     * ensuring consistent key prefixing (`aria-`), hyphenated key handling, and value propagation for scalars,
     * Stringable, UnitEnum, \Closure, `null` and without `aria-` prefix in keys.
     *
     * Each test case includes the input value, the expected normalized attributes array, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `aria-*` attribute map scenarios.
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

        $staticCases = [
            'boolean false' => [
                ['aria-pressed' => false],
                ['aria-pressed' => 'false'],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                ['aria-pressed' => true],
                ['aria-pressed' => 'true'],
                'Should return the attribute value after setting it.',
            ],
            'closure with array' => [
                ['aria-controls' => static fn(): array => ['key' => 'value']],
                ['aria-controls' => ['key' => 'value']],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean false' => [
                ['aria-pressed' => static fn(): bool => false],
                ['aria-pressed' => 'false'],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean true' => [
                ['aria-pressed' => static fn(): bool => true],
                ['aria-pressed' => 'true'],
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                ['aria-label' => static fn(): string => ''],
                ['aria-label' => ''],
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                ['aria-size' => static fn(): ButtonSize => ButtonSize::SMALL],
                ['aria-size' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                ['aria-value' => static fn(): float => 0.42],
                ['aria-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                ['aria-value' => static fn(): int => 42],
                ['aria-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                ['aria-label' => static fn(): null|string => null],
                [],
                'Should return the attribute value after setting it.',
            ],
            'closure with string' => [
                ['aria-label' => static fn(): string => 'Close'],
                ['aria-label' => 'Close'],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['aria-label' => ''],
                ['aria-label' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'enum value' => [
                ['aria-size' => ButtonSize::SMALL],
                ['aria-size' => ButtonSize::SMALL],
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                ['aria-value' => 0.42],
                ['aria-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                ['aria-describedby' => 'desc'],
                ['aria-describedby' => 'desc'],
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                ['aria-value' => 42],
                ['aria-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'aria-label' => 'Close',
                    'aria-controls' => static fn(): string => 'modal-1',
                ],
                [
                    'aria-label' => 'Close',
                    'aria-controls' => 'modal-1',
                ],
                "Should set multiple 'aria' attributes with mixed string and closure values.",
            ],
            'string' => [
                ['aria-label' => 'Close'],
                ['aria-label' => 'Close'],
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                ['aria-label' => $stringable],
                ['aria-label' => $stringable],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                ['aria-label' => null],
                [],
                "Should unset the 'aria-label' attribute when 'null' is provided after a value.",
            ],
            'without aria prefix' => [
                ['pressed' => true],
                ['aria-pressed' => 'true'],
                'Should normalize key without aria prefix when setting the attribute.',
            ],
        ];

        return $staticCases;
    }
}
