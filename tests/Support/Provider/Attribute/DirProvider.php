<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use UIAwesome\Html\Core\Tests\Support\EnumDataGenerator;
use UIAwesome\Html\Core\Values\Direction;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasDirTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `dir` attribute in tag rendering,
 * ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `dir` attribute, supporting both
 * explicit string, UnitEnum for enum-based direction values, and `null` for attribute removal, to maintain
 * consistent output across different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of the `dir` attribute in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of string (including empty strings), UnitEnum, and `null` for the `dir` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class DirProvider
{
    /**
     * Provides test cases for rendered HTML `dir` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `dir` attribute, including
     * string, UnitEnum, and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `dir` attribute scenarios.
     *
     * @phpstan-return array<string, array{string|UnitEnum|null, mixed[], string|UnitEnum, string}>
     */
    public static function renderAttribute(): array
    {
        $enumCases = EnumDataGenerator::cases(Direction::class, 'dir', true);

        $staticCase = [
            'empty string' => [
                '',
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum replace existing' => [
                Direction::AUTO,
                ['dir' => 'ltr'],
                ' dir="auto"',
                "Should return new 'dir' after replacing the existing 'dir' attribute with enum value.",
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'auto',
                ['dir' => 'ltr'],
                ' dir="auto"',
                "Should return new 'dir' after replacing the existing 'dir' attribute.",
            ],
            'string' => [
                'ltr',
                [],
                ' dir="ltr"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['dir' => 'ltr'],
                '',
                "Should unset the 'dir' attribute when 'null' is provided after a value.",
            ],
        ];

        return [...$staticCase, ...$enumCases];
    }

    /**
     * Provides test cases for HTML `dir` attribute value scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `dir` attribute,
     * including string, UnitEnum, and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `dir` attribute value scenarios.
     *
     * @phpstan-return array<string, array{string|UnitEnum|null, mixed[], string|UnitEnum, string}>
     */
    public static function values(): array
    {
        $enumCases = EnumDataGenerator::cases(Direction::class, 'dir', false);

        $staticCase = [
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
                'auto',
                ['dir' => 'ltr'],
                'auto',
                "Should return new 'dir' after replacing the existing 'dir' attribute.",
            ],
            'string' => [
                'ltr',
                [],
                'ltr',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['dir' => 'ltr'],
                '',
                "Should unset the 'dir' attribute when 'null' is provided after a value.",
            ],
        ];

        return [...$staticCase, ...$enumCases];
    }
}
