<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Provider;

use BackedEnum;
use UIAwesome\Html\Core\Tests\Support\Stub\NumericContextName;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Config\ComponentContextTest} test cases.
 */
final class ComponentContextProvider
{
    /**
     * @phpstan-return array<
     *   string,
     *   array{
     *     string,
     *     BackedEnum|string,
     *     BackedEnum|string|null,
     *     BackedEnum|string|null,
     *     BackedEnum|string|null,
     *     list<BackedEnum|string>,
     *   },
     * >
     */
    public static function intBackedEnumNames(): array
    {
        return [
            'component' => [
                'Component identifier',
                NumericContextName::ONE,
                null,
                null,
                null,
                [],
            ],
            'scheme' => [
                'Scheme',
                'alert',
                null,
                null,
                NumericContextName::ONE,
                [],
            ],
            'size' => [
                'Size',
                'alert',
                null,
                NumericContextName::ONE,
                null,
                [],
            ],
            'state' => [
                'Component state',
                'alert',
                null,
                null,
                null,
                ['dismissible', NumericContextName::ONE],
            ],
            'variant' => [
                'Variant',
                'alert',
                NumericContextName::ONE,
                null,
                null,
                [],
            ],
        ];
    }
}
