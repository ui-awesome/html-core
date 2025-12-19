<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasMicroDataTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `itemid` attribute in tag rendering,
 * ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `itemid` attribute, supporting
 * both explicit string and `null` for attribute removal, to maintain consistent output across different rendering
 * configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of the `itemid` attribute in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of string (including empty strings) and `null` for the `itemid` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class ItemIdProvider
{
    /**
     * Provides test cases for rendered HTML `itemid` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `itemid` attribute,
     * including empty string and `null` for attribute removal.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `itemid` attribute scenarios.
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
                'new-id',
                ['itemid' => 'old-id'],
                ' itemid="new-id"',
                "Should return new 'itemid' after replacing the existing 'itemid' attribute.",
            ],
            'string' => [
                'id-one',
                [],
                ' itemid="id-one"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['itemid' => 'id-two'],
                '',
                "Should unset the 'itemid' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `itemid` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `itemid` attribute,
     * including empty string and `null` for attribute removal.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `itemid` attribute scenarios.
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
                'new-id',
                ['itemid' => 'old-id'],
                'new-id',
                "Should return new 'itemid' after replacing the existing 'itemid' attribute.",
            ],
            'string' => [
                'id-one',
                [],
                'id-one',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['itemid' => 'id-two'],
                '',
                "Should unset the 'itemid' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
