<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasSpellcheckTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `spellcheck` attribute in tag
 * rendering, ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `spellcheck` attribute,
 * supporting explicit bool, string, and `null` for attribute removal, to maintain consistent output across different
 * rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of the `spellcheck` attribute in HTML element
 *   rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of bool, string, and `null` for the `spellcheck` attribute, including replacement and unset scenarios.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class SpellcheckProvider
{
    /**
     * Provides test cases for rendered HTML `spellcheck` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `spellcheck` attribute,
     * including bool, string, and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `spellcheck` attribute scenarios.
     *
     * @phpstan-return array<string, array{bool|string|null, mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'boolean false' => [
                false,
                [],
                ' spellcheck="false"',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                true,
                [],
                ' spellcheck="true"',
                'Should return the attribute value after setting it.',
            ],
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
                'true',
                ['spellcheck' => 'false'],
                ' spellcheck="true"',
                "Should return new 'spellcheck' after replacing the existing 'spellcheck' attribute.",
            ],
            'string boolean false' => [
                'false',
                [],
                ' spellcheck="false"',
                'Should return the attribute value after setting it.',
            ],
            'string boolean true' => [
                'true',
                [],
                ' spellcheck="true"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['spellcheck' => 'true'],
                '',
                "Should unset the 'spellcheck' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `spellcheck` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `spellcheck` attribute,
     * including bool, string, and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `spellcheck` attribute scenarios.
     *
     * @phpstan-return array<string, array{bool|string|null, mixed[], string, string}>
     */
    public static function values(): array
    {
        return [
            'boolean false' => [
                false,
                [],
                'false',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                true,
                [],
                'true',
                'Should return the attribute value after setting it.',
            ],
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
                'true',
                ['spellcheck' => 'false'],
                'true',
                "Should return new 'spellcheck' after replacing the existing 'spellcheck' attribute.",
            ],
            'string boolean false' => [
                'false',
                [],
                'false',
                'Should return the attribute value after setting it.',
            ],
            'string boolean true' => [
                'true',
                [],
                'true',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['spellcheck' => 'true'],
                '',
                "Should unset the 'spellcheck' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
