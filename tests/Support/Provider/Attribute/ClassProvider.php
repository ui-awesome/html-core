<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use Stringable;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\AlertType;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasClassTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `class` attribute in tag rendering,
 * ensuring standards-compliant assignment, appending, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, appending, overriding, and removing the `class` attribute,
 * supporting both explicit string, UnitEnum for enum-based, and `null` for attribute removal, to maintain consistent
 * output across different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, appending, override, and removal of the `class` attribute in HTML element
 *   rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of string (including empty strings), UnitEnum and `null` for the `class` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class ClassProvider
{
    /**
     * Provides test cases for rendered HTML `class` attribute scenarios.
     *
     * Supplies test data for validating assignment, appending, override, and removal of the global HTML `class`
     * attribute, including empty string, UnitEnum, `null`, standard string and Stringable.
     *
     * Each test case includes the input value, the initial attributes, the override flag, the expected rendered output,
     * and an assertion message for clear identification.
     *
     * @return array Test data for rendered `class` attribute scenarios.
     *
     * @phpstan-return array<string, array{string|Stringable|UnitEnum|null, mixed[], bool, string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'append' => [
                'class-two',
                ['class' => 'class-one'],
                false,
                ' class="class-one class-two"',
                "Should append new class to existing 'class' attribute.",
            ],
            'empty string' => [
                '',
                [],
                false,
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum' => [
                AlertType::WARNING,
                [],
                false,
                ' class="warning"',
                'Should return the attribute value after setting it with an enum.',
            ],
            'enum replace existing' => [
                AlertType::WARNING,
                ['class' => 'class-one'],
                true,
                ' class="warning"',
                "Should return new 'class' after replacing the existing 'class' attribute with enum value.",
            ],
            'null' => [
                null,
                [],
                false,
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'class-override',
                ['class' => 'class-one'],
                true,
                ' class="class-override"',
                "Should return new 'class' after replacing the existing 'class' attribute.",
            ],
            'string' => [
                'class-two',
                [],
                false,
                ' class="class-two"',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                new class implements Stringable {
                    public function __toString(): string
                    {
                        return 'class-stringable';
                    }
                },
                [],
                false,
                ' class="class-stringable"',
                'Should return the attribute value after setting it with a Stringable object.',
            ],
            'unset with null' => [
                null,
                ['class' => 'class-two'],
                false,
                '',
                "Should unset the 'class' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `class` attribute scenarios.
     *
     * Supplies test data for validating assignment, appending, and override of the global HTML `class` attribute,
     * including empty string, UnitEnum, `null`, standard string and Stringable.
     *
     * Each test case includes the input value, the expected output, and an assertion message for clear identification.
     *
     * @return array Test data for `class` attribute scenarios.
     *
     * @phpstan-return array<
     *   string,
     *   array{array<array{value: string|Stringable|UnitEnum|null, override?: bool}>, string, string}
     * >
     */
    public static function values(): array
    {
        return [
            'append' => [
                [
                    ['value' => 'class-one'],
                    ['value' => 'class-two'],
                ],
                'class-one class-two',
                "Should append new class to existing 'class' attribute.",
            ],
            'empty string' => [
                [['value' => '']],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum' => [
                [['value' => AlertType::WARNING]],
                'warning',
                'Should return the attribute value after setting it with an enum.',
            ],
            'multiple appends when override (true)' => [
                [
                    ['value' => 'class-one'],
                    ['value' => 'class-two'],
                    [
                        'override' => true,
                        'value' => 'class-three',
                    ],
                ],
                'class-three',
                'Should override all previous class values when override flag is true.',
            ],
            'null' => [
                [['value' => null]],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'override' => [
                [
                    ['value' => 'class-one'],
                    [
                        'override' => true,
                        'value' => 'class-override',
                    ],
                ],
                'class-override',
                'Should return new attribute value after overriding the existing attribute value.',
            ],
            'string' => [
                [['value' => 'class-one']],
                'class-one',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                [
                    [
                        'value' => new class implements Stringable {
                            public function __toString(): string
                            {
                                return 'class-stringable';
                            }
                        },
                    ],
                ],
                'class-stringable',
                'Should return the attribute value after setting it with a Stringable object.',
            ],
            'unset with null' => [
                [
                    ['value' => 'class-one'],
                    ['value' => null],
                ],
                '',
                "Should unset the 'class' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
