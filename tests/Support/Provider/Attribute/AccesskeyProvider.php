<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasAccesskeyTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `accesskey` attribute in tag
 * rendering, ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and unsetting the `accesskey` attribute,
 * supporting both explicit string and `null` for attribute removal, to maintain consistent output across different
 * rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, override, and removal of the `accesskey` attribute in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of empty string, `null`, and standard string for the `accesskey` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class AccesskeyProvider
{
    /**
     * Provides test cases for HTML `accesskey` attribute rendering scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `accesskey` attribute,
     * including empty string, `null`, and standard string.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for `accesskey` attribute rendering scenarios.
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
                'key',
                ['accesskey' => 'old-key'],
                ' accesskey="key"',
                "Should return new 'accesskey' after replacing the existing 'accesskey' attribute.",
            ],
            'string' => [
                'key',
                [],
                ' accesskey="key"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['accesskey' => 'old-key'],
                '',
                "Should unset the 'accesskey' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `accesskey` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `accesskey` attribute,
     * including empty string, `null`, and standard string.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `accesskey` attribute scenarios.
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
                'key',
                ['accesskey' => 'old-key'],
                'key',
                "Should return new 'accesskey' after replacing the existing 'accesskey' attribute.",
            ],
            'string' => [
                'key',
                [],
                'key',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['accesskey' => 'old-key'],
                '',
                "Should unset the 'accesskey' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
