<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use Stringable;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\AlertType;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasStyleTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `style` attribute in tag rendering,
 * ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `style` attribute, supporting
 * explicit array, string, UnitEnum for enum-based, and `null` for attribute removal, to maintain consistent output
 * across different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, and override of the `style` attribute in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of array, string (including empty strings), UnitEnum and `null` for the `style` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class StyleProvider
{
    /**
     * Provides test cases for rendered HTML `style` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `style` attribute,
     * including array, empty string, UnitEnum, `null`, standard string, and Stringable.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `style` attribute scenarios.
     *
     * @phpstan-return array<string, array{mixed[]|string|Stringable|UnitEnum|null, mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'array' => [
                ['color' => 'red', 'font-size' => '16px'],
                [],
                ' style=\'color: red; font-size: 16px;\'',
                'Should return the attribute value after setting it with an array.',
            ],
            'empty string' => [
                '',
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum' => [
                AlertType::WARNING,
                [],
                ' style="warning"',
                'Should return the attribute value after setting it with an enum.',
            ],
            'enum replace existing' => [
                AlertType::WARNING,
                ['style' => 'color: red;'],
                ' style="warning"',
                "Should return new 'style' after replacing the existing 'style' attribute with enum value.",
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'color: blue;',
                ['style' => 'color: red;'],
                ' style="color: blue;"',
                "Should return new 'style' after replacing the existing 'style' attribute.",
            ],
            'string' => [
                'color: red;',
                [],
                ' style="color: red;"',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                new class implements Stringable {
                    public function __toString(): string
                    {
                        return 'color: green;';
                    }
                },
                [],
                ' style="color: green;"',
                'Should return the attribute value after setting it with a Stringable instance.',
            ],
            'unset with null' => [
                null,
                ['style' => 'color: red;'],
                '',
                "Should unset the 'style' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `style` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `style` attribute,
     * including array, empty string, UnitEnum, `null`, standard string, and Stringable.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `style` attribute scenarios.
     *
     * @phpstan-return array<
     *   string,
     *   array{mixed[]|string|Stringable|UnitEnum|null, mixed[], mixed[]|string|Stringable|UnitEnum, string},
     * >
     */
    public static function values(): array
    {
        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'color: green;';
            }
        };

        return [
            'array' => [
                ['color' => 'red', 'font-size' => '16px'],
                [],
                ['color' => 'red', 'font-size' => '16px'],
                'Should return the attribute value after setting it with an array.',
            ],
            'empty string' => [
                '',
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum' => [
                AlertType::WARNING,
                [],
                AlertType::WARNING,
                'Should return the enum instance after setting it.',
            ],
            'enum replace existing' => [
                AlertType::WARNING,
                ['style' => 'color: red;'],
                AlertType::WARNING,
                "Should return new 'style' after replacing the existing 'style' attribute with enum value.",
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'color: blue;',
                ['style' => 'color: red;'],
                'color: blue;',
                "Should return new 'style' after replacing the existing 'style' attribute.",
            ],
            'string' => [
                'color: red;',
                [],
                'color: red;',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                $stringable,
                [],
                $stringable,
                'Should return the attribute value after setting it with a Stringable instance.',
            ],
            'unset with null' => [
                null,
                ['style' => 'color: red;'],
                '',
                "Should unset the 'style' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
