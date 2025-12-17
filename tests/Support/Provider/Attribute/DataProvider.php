<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use UIAwesome\Html\Core\Tests\Support\Stub\Enum\ButtonSize;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasDataTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `data-*` attributes in tag rendering,
 * ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing `data-*` attributes, supporting both
 * explicit string, Closure for dynamic values, and `null` for attribute removal, to maintain consistent output across
 * different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, and override of `data-*` attributes in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of empty string, `null`, Closure and UnitEnum for `data-*` attributes.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class DataProvider
{
    /**
     * Provides test cases for rendered HTML `data-*` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `data-*` attributes,
     * including empty string, `null`, Closure, UnitEnum, and standard string.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `data-*` attribute scenarios.
     *
     * @phpstan-return array<string, array{array<string, string|\Closure(): mixed>, mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'closure with array' => [
                ['value' => static fn(): array => ['key' => 'value']],
                [],
                ' data-value=\'{"key":"value"}\'',
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean (false)' => [
                ['value' => static fn(): bool => false],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean (true)' => [
                ['value' => static fn(): bool => true],
                [],
                ' data-value',
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                ['value' => static fn(): string => ''],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                ['value' => static fn(): ButtonSize => ButtonSize::SMALL],
                [],
                ' data-value="sm"',
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                ['value' => static fn(): float => 0.42],
                [],
                ' data-value="0.42"',
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                ['value' => static fn(): int => 42],
                [],
                ' data-value="42"',
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                ['value' => static fn(): null|string => null],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with string' => [
                ['value' => static fn(): string => 'test-action'],
                [],
                ' data-value="test-action"',
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['value' => ''],
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'hyphenated key' => [
                ['custom-action' => 'value'],
                [],
                ' data-custom-action="value"',
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'action' => 'test-action',
                    'callback' => static fn(): string => 'test-callback',
                ],
                [],
                ' data-action="test-action" data-callback="test-callback"',
                "Should set multiple 'data' attributes with mixed string and closure values.",
            ],
            'multiple string' => [
                [
                    'action' => 'test-action',
                    'id' => 'test-id',
                    'value' => 'test-value',
                ],
                [],
                ' data-action="test-action" data-id="test-id" data-value="test-value"',
                "Should set multiple 'data' attributes with string values.",
            ],
            'string' => [
                ['action' => 'test-action'],
                [],
                ' data-action="test-action"',
                'Should return the attribute value after setting it.',
            ],
        ];
    }

    /**
     * Provides test cases for HTML `data-*` attribute value scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `data-*` attribute,
     * including empty string, `null`, Closure, and standard string.
     *
     * Each test case includes the input value, the expected output, and an assertion message for clear identification.
     *
     * @return array Test data for `data-*` attribute value scenarios.
     *
     * @phpstan-return array<
     *   string,
     *   array{
     *     array<string, string|\Closure(): mixed>,
     *     array<string, string|\Closure(): mixed>,
     *     string,
     *   }
     * >
     */
    public static function values(): array
    {
        $closure = static fn(): string => 'test-action';

        return [
            'closure' => [
                ['value' => $closure],
                ['data-value' => $closure],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['value' => ''],
                ['data-value' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'hyphenated key' => [
                ['custom-action' => 'value'],
                ['data-custom-action' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'action' => 'test-action',
                    'callback' => $closure,
                ],
                [
                    'data-action' => 'test-action',
                    'data-callback' => $closure,
                ],
                "Should set multiple 'data' attributes with mixed string and closure values.",
            ],
            'multiple string' => [
                [
                    'action' => 'test-action',
                    'id' => 'test-id',
                    'value' => 'test-value',
                ],
                [
                    'data-action' => 'test-action',
                    'data-id' => 'test-id',
                    'data-value' => 'test-value',
                ],
                "Should set multiple 'data' attributes with string values.",
            ],
            'string' => [
                ['action' => 'test-action'],
                ['data-action' => 'test-action'],
                'Should return the attribute value after setting it.',
            ],
        ];
    }
}
