<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use Stringable;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\Priority;
use UIAwesome\Html\Core\Values\Event;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasEventsTest} class.
 *
 * Supplies comprehensive test data for validating the handling of HTML `on*` event handler attributes in tag rendering,
 * ensuring standards-compliant attribute generation, key normalization, override behavior, and value propagation.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing `on*` event attributes, supporting
 * string, Stringable, UnitEnum, and deferred evaluation via \Closure, to maintain consistent output across different
 * rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, override, and removal of `on*` event attributes in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of string (including empty strings), UnitEnum, \Closure, and `null` handling for `on*` event attributes,
 *   including enforcement of `on` prefix and unset scenarios.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class EventProvider
{
    /**
     * Provides test cases for rendered HTML `on*` event attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of HTML `on*` event handler attributes,
     * including string, Stringable, UnitEnum, and deferred evaluation via \Closure.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `on*` event attribute scenarios.
     *
     * @phpstan-return array<string, array{mixed[], mixed[], string, string}>
     */
    public static function renderAttribute(): array
    {
        return [
            'closure with array' => [
                ['onclick' => static fn(): array => ['key' => 'value']],
                [],
                " onclick='{\"key\":\"value\"}'",
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean false' => [
                ['onclick' => static fn(): bool => false],
                [],
                ' onclick="false"',
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean true' => [
                ['onclick' => static fn(): bool => true],
                [],
                ' onclick="true"',
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                ['onclick' => static fn(): string => ''],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                ['onclick' => static fn(): UnitEnum => Priority::HIGH],
                [],
                ' onclick="2"',
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                ['onclick' => static fn(): float => 3.14],
                [],
                ' onclick="3.14"',
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                ['onclick' => static fn(): int => 42],
                [],
                ' onclick="42"',
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                ['onclick' => static fn() => null],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'closure with string' => [
                ['onclick' => static fn(): string => "alert('hello')"],
                [],
                ' onclick="alert(&apos;hello&apos;)"',
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['onclick' => ''],
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum value' => [
                ['onclick' => Priority::LOW],
                [],
                ' onclick="1"',
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'onclick' => "alert('click')",
                    'onsubmit' => static fn(): string => 'return validate()',
                ],
                [],
                ' onclick="alert(&apos;click&apos;)" onsubmit="return validate()"',
                "Should set multiple 'on*' event attributes with mixed string and closure values.",
            ],
            'string' => [
                ['onclick' => "alert('test')"],
                [],
                ' onclick="alert(&apos;test&apos;)"',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                [
                    'onclick' => new class implements Stringable {
                        public function __toString(): string
                        {
                            return 'console.log("stringable")';
                        }
                    },
                ],
                [],
                ' onclick="console.log(&quot;stringable&quot;)"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                ['onclick' => null],
                ['onclick' => "alert('old')"],
                '',
                "Should unset the 'onclick' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for single HTML `on*` event attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of a single HTML `on*` event attribute,
     * including string keys, enum-based keys via UnitEnum, and values provided as string, Stringable, \Closure, and
     * `null`.
     *
     * Each test case includes the attribute key, the input value, the expected attributes array, and an assertion
     * message for clear identification.
     *
     * @return array Test data for single `on*` event attribute scenarios.
     *
     * @phpstan-return array<
     *   string,
     *   array{string|UnitEnum, string|Stringable|UnitEnum|\Closure(): mixed|null, mixed[], string},
     * >
     */
    public static function value(): array
    {
        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'console.log("test")';
            }
        };

        return [
            'closure with array' => [
                'onclick',
                static fn(): array => ['key' => 'value'],
                ['onclick' => ['key' => 'value']],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean false' => [
                'onclick',
                static fn(): bool => false,
                ['onclick' => 'false'],
                'Should return the attribute value after setting it.',
            ],
            'closure with boolean true' => [
                'onclick',
                static fn(): bool => true,
                ['onclick' => 'true'],
                'Should return the attribute value after setting it.',
            ],
            'closure with empty string' => [
                'onclick',
                static fn(): string => '',
                ['onclick' => ''],
                'Should return the attribute value after setting it.',
            ],
            'closure with enum' => [
                'onclick',
                static fn(): UnitEnum => Priority::HIGH,
                ['onclick' => Priority::HIGH],
                'Should return the attribute value after setting it.',
            ],
            'closure with float' => [
                'onclick',
                static fn(): float => 3.14,
                ['onclick' => 3.14],
                'Should return the attribute value after setting it.',
            ],
            'closure with integer' => [
                'onclick',
                static fn(): int => 42,
                ['onclick' => 42],
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                'onclick',
                static fn() => null,
                [],
                'Should unset the attribute when closure returns null.',
            ],
            'closure with string' => [
                'onclick',
                static fn(): string => "alert('closure')",
                ['onclick' => "alert('closure')"],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                'onclick',
                '',
                ['onclick' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'enum key' => [
                Event::INVALID,
                'value',
                ['oninvalid' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'enum value' => [
                'onsubmit',
                Priority::LOW,
                ['onsubmit' => Priority::LOW],
                'Should return the attribute value after setting it.',
            ],
            'string' => [
                'onclick',
                "alert('test')",
                ['onclick' => "alert('test')"],
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                'onclick',
                $stringable,
                ['onclick' => $stringable],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                'onclick',
                null,
                [],
                'Should unset the attribute when null is provided.',
            ],
        ];
    }

    /**
     * Provides test cases for HTML `on*` event attribute map scenarios.
     *
     * Supplies test data for validating bulk assignment, normalization, and removal of HTML `on*` event handler
     * attributes, ensuring consistent key prefixing (`on`), event name handling, and value propagation for string,
     * Stringable, UnitEnum, Closure, and `null`.
     *
     * Each test case includes the input value, the expected normalized attributes array, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `on*` event attribute map scenarios.
     *
     * @phpstan-return array<string, array{mixed[], mixed[], string}>
     */
    public static function values(): array
    {
        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'console.log("bulk")';
            }
        };

        $enumCases = [];

        foreach (Event::cases() as $case) {
            $eventName = $case->value;
            $enumCases["enum: {$eventName}"] = [
                [$case->value => "alert('test')"],
                [$eventName => "alert('test')"],
                "Should normalize enum case '{$case->name}' to attribute '{$eventName}'.",
            ];
        }

        $staticCases = [
            'closure with empty string' => [
                ['onclick' => static fn(): string => ''],
                ['onclick' => ''],
                'Should return the attribute value after setting it.',
            ],
            'closure with null' => [
                ['onclick' => static fn() => null],
                [],
                'Should unset the attribute when closure returns null.',
            ],
            'closure with string' => [
                ['onclick' => static fn(): string => "alert('closure')"],
                ['onclick' => "alert('closure')"],
                'Should return the attribute value after setting it.',
            ],
            'empty array' => [
                [],
                [],
                'Should return an empty array when no events are provided.',
            ],
            'empty string' => [
                ['onclick' => ''],
                ['onclick' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'multiple events' => [
                [
                    'onclick' => "alert('click')",
                    'onsubmit' => 'return validate()',
                    'onblur' => "console.log('blur')",
                ],
                [
                    'onclick' => "alert('click')",
                    'onsubmit' => 'return validate()',
                    'onblur' => "console.log('blur')",
                ],
                'Should set multiple event attributes at once.',
            ],
            'string' => [
                ['onclick' => "alert('test')"],
                ['onclick' => "alert('test')"],
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                ['onclick' => $stringable],
                ['onclick' => $stringable],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                ['onclick' => null],
                [],
                'Should unset the attribute when null is provided.',
            ],
        ];

        return [...$staticCases, ...$enumCases];
    }
}
