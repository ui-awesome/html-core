<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use UIAwesome\Html\Core\Tests\Support\Stub\Enum\ButtonSize;
use UIAwesome\Html\Core\Values\DataProperty;
use UnitEnum;

final class DataProvider
{
    /**
     * @phpstan-return array<
     *   string,
     *   array{array<string, scalar|\Closure(): mixed|UnitEnum|null>, mixed[], string, string},
     * >
     */
    public static function renderAttribute(): array
    {
        return [
            'boolean false' => [
                ['value' => static fn(): bool => false],
                [],
                '',
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                ['value' => static fn(): bool => true],
                [],
                ' data-value',
                'Should return the attribute value after setting it.',
            ],
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
                ['value' => static fn(): string => 'action'],
                [],
                ' data-value="action"',
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                ['value' => ''],
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum value' => [
                ['size' => ButtonSize::SMALL],
                [],
                ' data-size="sm"',
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                ['value' => 0.42],
                [],
                ' data-value="0.42"',
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                ['custom-action' => 'value'],
                [],
                ' data-custom-action="value"',
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                ['value' => 42],
                [],
                ' data-value="42"',
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'action' => 'action',
                    'callback' => static fn(): string => 'callback',
                ],
                [],
                ' data-action="action" data-callback="callback"',
                "Should set multiple 'data' attributes with mixed string and closure values.",
            ],
            'multiple string' => [
                [
                    'action' => 'action',
                    'id' => 'id',
                    'value' => 'value',
                ],
                [],
                ' data-action="action" data-id="id" data-value="value"',
                "Should set multiple 'data' attributes with string values.",
            ],
            'string' => [
                ['action' => 'action'],
                [],
                ' data-action="action"',
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                ['value' => null],
                [],
                '',
                "Should unset the 'data-value' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * @phpstan-return array<string, array{string|UnitEnum, scalar|\Closure(): mixed|UnitEnum|null, mixed[], string}>
     */
    public static function value(): array
    {
        $closure = static fn(): string => 'action';

        return [
            'boolean false' => [
                'value',
                false,
                ['data-value' => false],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                'value',
                true,
                ['data-value' => true],
                'Should return the attribute value after setting it.',
            ],
            'closure' => [
                'value',
                $closure,
                ['data-value' => $closure],
                'Should return the attribute value after setting it.',
            ],
            'empty string' => [
                'value',
                '',
                ['data-value' => ''],
                'Should return an empty string when setting an empty string.',
            ],
            'enum key' => [
                DataProperty::ACTION,
                'action',
                ['data-action' => 'action'],
                'Should return the attribute value after setting it.',
            ],
            'enum value' => [
                'size',
                ButtonSize::SMALL,
                ['data-size' => 'sm'],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                'custom-action',
                'value',
                ['data-custom-action' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'string' => [
                'action',
                'action',
                ['data-action' => 'action'],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                'value',
                null,
                [],
                "Should unset the 'data-value' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * @phpstan-return array<
     *   string,
     *   array{
     *     array<string, scalar|\Closure(): mixed|UnitEnum|null>,
     *     array<string, scalar|\Closure(): mixed>,
     *     string,
     *   }
     * >
     */
    public static function values(): array
    {
        $closure = static fn(): string => 'action';

        return [
            'boolean false' => [
                ['value' => false],
                ['data-value' => false],
                'Should return the attribute value after setting it.',
            ],
            'boolean true' => [
                ['value' => true],
                ['data-value' => true],
                'Should return the attribute value after setting it.',
            ],
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
            'enum value' => [
                ['size' => ButtonSize::SMALL],
                ['data-size' => 'sm'],
                'Should return the attribute value after setting it.',
            ],
            'float' => [
                ['value' => 0.42],
                ['data-value' => 0.42],
                'Should return the attribute value after setting it.',
            ],
            'hyphenated key' => [
                ['custom-action' => 'value'],
                ['data-custom-action' => 'value'],
                'Should return the attribute value after setting it.',
            ],
            'integer' => [
                ['value' => 42],
                ['data-value' => 42],
                'Should return the attribute value after setting it.',
            ],
            'mixed string and closure' => [
                [
                    'action' => 'action',
                    'callback' => $closure,
                ],
                [
                    'data-action' => 'action',
                    'data-callback' => $closure,
                ],
                "Should set multiple 'data' attributes with mixed string and closure values.",
            ],
            'multiple string' => [
                [
                    'action' => 'action',
                    'id' => 'id',
                    'value' => 'value',
                ],
                [
                    'data-action' => 'action',
                    'data-id' => 'id',
                    'data-value' => 'value',
                ],
                "Should set multiple 'data' attributes with string values.",
            ],
            'string' => [
                ['action' => 'action'],
                ['data-action' => 'action'],
                'Should return the attribute value after setting it.',
            ],
            'unset with null' => [
                [
                    'value' => null,
                ],
                [],
                "Should unset the 'data-value' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
