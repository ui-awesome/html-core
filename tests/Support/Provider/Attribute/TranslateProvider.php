<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use UIAwesome\Html\Core\Tests\Support\EnumDataGenerator;
use UIAwesome\Html\Core\Values\Translate;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasTranslateTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `translate` attribute in tag
 * rendering, ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `translate` attribute, supporting
 * explicit bool, string, UnitEnum, and attribute replacement, to maintain consistent output across different rendering
 * configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of the `translate` attribute in HTML element
 *   rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of bool, string, UnitEnum, and `null` for the `translate` attribute, including replacement and unset
 *   scenarios.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TranslateProvider
{
    /**
     * Provides test cases for rendered HTML `translate` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `translate` attribute,
     * including bool, string, UnitEnum, and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `translate` attribute scenarios.
     *
     * @phpstan-return array<string, array{bool|string|UnitEnum|null, mixed[], string|UnitEnum, string}>
     */
    public static function renderAttribute(): array
    {
        $enumCases = EnumDataGenerator::cases(Translate::class, 'translate', true);

        $staticCase = [
            'boolean false' => [
                false,
                [],
                ' translate="no"',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                true,
                [],
                ' translate="yes"',
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                '',
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum replace existing' => [
                Translate::YES,
                ['translate' => 'no'],
                ' translate="yes"',
                "Should return new 'translate' after replacing the existing 'translate' attribute with enum value.",
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'true',
                ['translate' => 'no'],
                ' translate="yes"',
                "Should return new 'translate' after replacing the existing 'translate' attribute.",
            ],
            'string' => [
                'true',
                [],
                ' translate="yes"',
                'Should return the attribute value after setting it.',
            ],
            'string boolean false' => [
                'false',
                [],
                ' translate="no"',
                'Should return the attribute value after setting it.',
            ],
            'string boolean true' => [
                'true',
                [],
                ' translate="yes"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['translate' => 'yes'],
                '',
                "Should unset the 'translate' attribute when 'null' is provided after a value.",
            ],
        ];

        return [...$staticCase, ...$enumCases];
    }

    /**
     * Provides test cases for HTML `translate` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `translate` attribute,
     * including bool, string, UnitEnum, and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `translate` attribute scenarios.
     *
     * @phpstan-return array<string, array{bool|string|UnitEnum|null, mixed[], string|UnitEnum, string}>
     */
    public static function values(): array
    {
        $enumCases = EnumDataGenerator::cases(Translate::class, 'translate', false);

        $staticCase = [
            'boolean false' => [
                false,
                [],
                'no',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                true,
                [],
                'yes',
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
                ['translate' => 'no'],
                'yes',
                "Should return new 'translate' after replacing the existing 'translate' attribute.",
            ],
            'string' => [
                'true',
                [],
                'yes',
                'Should return the attribute value after setting it.',
            ],
            'string boolean false' => [
                'false',
                [],
                'no',
                'Should return the attribute value after setting it.',
            ],
            'string boolean true' => [
                'true',
                [],
                'yes',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['translate' => 'yes'],
                '',
                "Should unset the 'translate' attribute when 'null' is provided after a value.",
            ],
        ];

        return [...$staticCase, ...$enumCases];
    }
}
