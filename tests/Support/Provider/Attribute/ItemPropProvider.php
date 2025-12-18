<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasMicroDataTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `itemprop` attribute in tag
 * rendering, ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `itemprop` attribute, supporting
 * both explicit string and `null` for attribute removal, to maintain consistent output across different rendering
 * configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features:
 * - Ensures correct propagation, assignment, override, and removal of the `itemprop` attribute in HTML element
 *   rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of string (including empty strings) and `null` for the `itemprop` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class ItemPropProvider
{
    /**
     * Provides test cases for rendered HTML `itemprop` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `itemprop` attribute,
     * including empty string, `null`, and standard string.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `itemprop` attribute scenarios.
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
                'name',
                ['itemprop' => 'director'],
                ' itemprop="name"',
                "Should return new 'itemprop' after replacing the existing 'itemprop' attribute.",
            ],
            'string' => [
                'name',
                [],
                ' itemprop="name"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['itemprop' => 'name'],
                '',
                "Should unset the 'itemprop' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `itemprop` attribute value scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `itemprop` attribute,
     * including empty string, `null`, and standard string.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `itemprop` attribute value scenarios.
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
                'name',
                ['itemprop' => 'director'],
                'name',
                "Should return new 'itemprop' after replacing the existing 'itemprop' attribute.",
            ],
            'string' => [
                'name',
                [],
                'name',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['itemprop' => 'name'],
                '',
                "Should unset the 'itemprop' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
