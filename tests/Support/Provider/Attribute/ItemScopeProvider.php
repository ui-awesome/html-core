<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasMicroDataTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `itemscope` attribute in tag
 * rendering, ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `itemscope` attribute, supporting
 * both explicit bool and `null` for attribute removal, to maintain consistent output across different rendering
 * configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of the `itemscope` attribute in HTML element
 *   rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of bool and `null` for the `itemscope` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class ItemScopeProvider
{
    /**
     * Provides test cases for rendered HTML `itemscope` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `itemscope` attribute,
     * including bool and `null` for attribute removal.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `itemscope` attribute scenarios.
     *
     * @phpstan-return array<string, array{bool|null, mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'boolean false' => [
                false,
                [],
                '',
                "Should return an empty string when setting boolean 'false'.",
            ],
            'boolean true' => [
                true,
                [],
                ' itemscope',
                "Should return 'itemscope' when setting boolean 'true'.",
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                true,
                ['itemscope' => false],
                ' itemscope',
                "Should return 'itemscope' after replacing the existing 'itemscope' attribute.",
            ],
            'unset with null' => [
                null,
                ['itemscope' => true],
                '',
                "Should unset the 'itemscope' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `itemscope` attribute value scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `itemscope` attribute,
     * including bool and `null` for attribute removal.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `itemscope` attribute value scenarios.
     *
     * @phpstan-return array<string, array{bool|null, mixed[], bool|string, string}>
     */
    public static function values(): array
    {
        return [
            'boolean false' => [
                false,
                [],
                false,
                "Should return 'false' when setting boolean 'false'.",
            ],
            'boolean true' => [
                true,
                [],
                true,
                "Should return 'true' when setting boolean 'true'.",
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                true,
                ['itemscope' => false],
                true,
                "Should return 'true' after replacing the existing 'itemscope' attribute.",
            ],
            'unset with null' => [
                null,
                ['itemscope' => true],
                '',
                "Should unset the 'itemscope' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
