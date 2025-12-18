<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasTabIndexTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `tabindex` attribute in tag
 * rendering, ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `tabindex` attribute, supporting
 * both explicit int and string, as well as `null` for attribute removal, to maintain consistent output across different
 * rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of the `tabindex` attribute in HTML element
 *   rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of int, string (including empty strings), and `null` for the `tabindex` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TabIndexProvider
{
    /**
     * Provides test cases for invalid HTML `tabindex` attribute values.
     *
     * Supplies test data for validating rejection of non-standard or out-of-range values for the global HTML `tabindex`
     * attribute, including negative integers less than `-1`, non-numeric strings, and float values.
     *
     * Each test case includes the input value for clear identification.
     *
     * @return array Test data for invalid `tabindex` attribute values.
     *
     * @phpstan-return array<string, array{int|string|null}>
     */
    public static function invalidValues(): array
    {
        return [
            'integer negative less than -1' => [
                -2,
            ],
            'string float' => [
                '5.5',
            ],
            'string negative less than -1' => [
                '-2',
            ],
            'string non-numeric' => [
                'invalid',
            ],
        ];
    }

    /**
     * Provides test cases for rendered HTML `tabindex` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `tabindex` attribute,
     * including int, string, and `null`, as well as replacement and unset scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `tabindex` attribute scenarios.
     *
     * @phpstan-return array<string, array{int|string|null, mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'integer' => [
                1,
                [],
                ' tabindex="1"',
                'Should return the attribute value after setting it.',
            ],
            'integer negative' => [
                -1,
                [],
                ' tabindex="-1"',
                'Should return the attribute value after setting it.',
            ],
            'integer zero' => [
                0,
                [],
                ' tabindex="0"',
                'Should return the attribute value after setting it.',
            ],
            'negative integer' => [
                -1,
                [],
                ' tabindex="-1"',
                'Should return the attribute value after setting it.',
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                2,
                ['tabindex' => 1],
                ' tabindex="2"',
                "Should return new 'tabindex' after replacing the existing 'tabindex' attribute.",
            ],
            'string negative' => [
                '-1',
                [],
                ' tabindex="-1"',
                'Should return the attribute value after setting it.',
            ],
            'string numeric' => [
                '3',
                [],
                ' tabindex="3"',
                'Should return the attribute value after setting it.',
            ],
            'string zero' => [
                '0',
                [],
                ' tabindex="0"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['tabindex' => 1],
                '',
                "Should unset the 'tabindex' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `tabindex` attribute value scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `tabindex` attribute
     * value, including int, string, and `null`, as well as replacement and unset scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected output array, and an assertion
     * message for clear identification.
     *
     * @return array Test data for `tabindex` attribute value scenarios.
     *
     * @phpstan-return array<string, array{int|string|null, mixed[], mixed[], string}>
     */
    public static function values(): array
    {
        return [
            'integer' => [
                1,
                [],
                ['tabindex' => 1],
                'Should return the attribute value after setting it.',
            ],
            'integer negative' => [
                -1,
                [],
                ['tabindex' => -1],
                'Should return the attribute value after setting it.',
            ],
            'integer zero' => [
                0,
                [],
                ['tabindex' => 0],
                'Should return the attribute value after setting it.',
            ],
            'null' => [
                null,
                [],
                [],
                "Should return an empty 'array' when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                2,
                ['tabindex' => 1],
                ['tabindex' => 2],
                "Should return new 'tabindex' after replacing the existing 'tabindex' attribute.",
            ],
            'string negative' => [
                '-1',
                [],
                ['tabindex' => '-1'],
                'Should return the attribute value after setting it.',
            ],
            'string numeric' => [
                '3',
                [],
                ['tabindex' => '3'],
                'Should return the attribute value after setting it.',
            ],
            'string zero' => [
                '0',
                [],
                ['tabindex' => '0'],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['tabindex' => 1],
                [],
                "Should unset the 'tabindex' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
