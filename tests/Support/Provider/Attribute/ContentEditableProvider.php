<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use UIAwesome\Html\Core\Tests\Support\EnumDataGenerator;
use UIAwesome\Html\Core\Values\ContentEditable;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasContentEditableTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `contenteditable` attribute in tag
 * rendering, ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `contenteditable` attribute,
 * supporting bool, string, UnitEnum, and `null` for attribute assignment and replacement, to maintain consistent output
 * across different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features:
 * - Ensures correct propagation, assignment, override, and removal of the `contenteditable` attribute in HTML element
 *   rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of bool, string, UnitEnum, and `null` for the `contenteditable` attribute, including replacement and
 *   unset scenarios.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class ContentEditableProvider
{
    /**
     * Provides test cases for rendered HTML `contenteditable` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `contenteditable`
     * attribute, including bool, string, UnitEnum, and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `contenteditable` attribute scenarios.
     *
     * @phpstan-return array<string, array{bool|string|UnitEnum|null, mixed[], string|UnitEnum, string}>
     */
    public static function renderAttribute(): array
    {
        $enumCases = EnumDataGenerator::cases(ContentEditable::class, 'contenteditable', true);

        $staticCase = [
            'boolean false' => [
                false,
                [],
                ' contenteditable="false"',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                true,
                [],
                ' contenteditable="true"',
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                '',
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum replace existing' => [
                ContentEditable::TRUE,
                ['contenteditable' => 'false'],
                ' contenteditable="true"',
                "Should return new 'contenteditable' after replacing the existing 'contenteditable' attribute with " .
                'enum value.',
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'plaintext-only',
                ['contenteditable' => 'false'],
                ' contenteditable="plaintext-only"',
                "Should return new 'contenteditable' after replacing the existing 'contenteditable' attribute.",
            ],
            'string' => [
                'true',
                [],
                ' contenteditable="true"',
                'Should return the attribute value after setting it.',
            ],
            'string boolean false' => [
                'false',
                [],
                ' contenteditable="false"',
                'Should return the attribute value after setting it.',
            ],
            'string boolean true' => [
                'true',
                [],
                ' contenteditable="true"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                null,
                ['contenteditable' => 'true'],
                '',
                "Should unset the 'contenteditable' attribute when 'null' is provided after a value.",
            ],
        ];

        return [...$staticCase, ...$enumCases];
    }

    /**
     * Provides test cases for HTML `contenteditable` attribute value scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `contenteditable`
     * attribute, including bool, string, UnitEnum, and replacement scenarios.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `contenteditable` attribute value scenarios.
     *
     * @phpstan-return array<string, array{bool|string|UnitEnum|null, mixed[], string|UnitEnum, string}>
     */
    public static function values(): array
    {
        $enumCases = EnumDataGenerator::cases(ContentEditable::class, 'contenteditable', false);

        $staticCase = [
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
                'plaintext-only',
                ['contenteditable' => 'false'],
                'plaintext-only',
                "Should return new 'contenteditable' after replacing the existing 'contenteditable' attribute.",
            ],
            'string' => [
                'true',
                [],
                'true',
                'Should return the attribute value after setting it.',
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
                ['contenteditable' => 'true'],
                '',
                "Should unset the 'contenteditable' attribute when 'null' is provided after a value.",
            ],
        ];

        return [...$staticCase, ...$enumCases];
    }
}
