<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasMicroDataTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `itemref` attribute in tag rendering,
 * ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `itemref` attribute, supporting
 * both explicit string and `null` for attribute removal, to maintain consistent output across different rendering
 * configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features:
 * - Ensures correct propagation, assignment, override, and removal of the `itemref` attribute in HTML element
 *   rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of string (including empty strings) and `null` for the `itemref` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class ItemRefProvider
{
    /**
     * Provides test cases for rendered HTML `itemref` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `itemref` attribute,
     * including empty string, `null`, and standard string.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `itemref` attribute scenarios.
     *
     * @phpstan-return array<string, array{string|null, mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'empty string' => [
                '',
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'a b',
                ['itemref' => 'c'],
                ' itemref="a b"',
                "Should return new 'itemref' after replacing the existing 'itemref' attribute.",
            ],
            'string' => [
                'a',
                [],
                ' itemref="a"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['itemref' => 'a'],
                '',
                "Should unset the 'itemref' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `itemref` attribute value scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `itemref` attribute,
     * including empty string, `null`, and standard string.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `itemref` attribute value scenarios.
     *
     * @phpstan-return array<string, array{string|null, mixed[], string, string}>
     */
    public static function values(): array
    {
        return [
            'empty string' => [
                '',
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'a b',
                ['itemref' => 'c'],
                'a b',
                "Should return new 'itemref' after replacing the existing 'itemref' attribute.",
            ],
            'string' => [
                'a b',
                [],
                'a b',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['itemref' => 'a b'],
                '',
                "Should unset the 'itemref' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
