<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\CanBeHiddenTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `hidden` attribute in tag rendering,
 * ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `hidden` attribute, supporting
 * both explicit bool and attribute replacement, to maintain consistent output across different rendering
 * configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of the `hidden` attribute in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of bool for the `hidden` attribute, including replacement and unset scenarios.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class HiddenProvider
{
    /**
     * Provides test cases for rendered HTML `hidden` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `hidden` attribute,
     * including bool and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `hidden` attribute scenarios.
     *
     * @phpstan-return array<string, array{bool, mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'boolean false' => [
                false,
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                true,
                [],
                ' hidden',
                'Should return the attribute value after setting it.',
            ],
            'replace existing false' => [
                false,
                ['hidden' => true],
                '',
                "Should return an empty string when replacing existing 'hidden' attribute with 'false'.",
            ],
            'replace existing true' => [
                true,
                ['hidden' => false],
                ' hidden',
                "Should return the attribute value when replacing existing 'hidden' attribute with 'true'.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `hidden` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `hidden` attribute,
     * including bool and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `hidden` attribute scenarios.
     *
     * @phpstan-return array<string, array{bool, mixed[], bool|string, string}>
     */
    public static function values(): array
    {
        return [
            'boolean false' => [
                false,
                [],
                false,
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                true,
                [],
                true,
                'Should return the attribute value after setting it.',
            ],
            'replace existing false' => [
                false,
                ['hidden' => true],
                false,
                "Should return 'false' when replacing existing 'hidden' attribute with 'false'.",
            ],
            'replace existing true' => [
                true,
                ['hidden' => false],
                true,
                "Should return 'true' when replacing existing 'hidden' attribute with 'true'.",
            ],
        ];
    }
}
