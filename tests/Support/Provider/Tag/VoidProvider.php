<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Tag;

use PHPForge\Support\EnumDataProvider;
use UIAwesome\Html\Interop\Voids;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\HtmlTest} test cases.
 *
 * Provides representative tag enum cases and expected tag names for void tags.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class VoidProvider
{
    /**
     * @phpstan-return array<string, array{UnitEnum, string}>
     */
    public static function voidTags(): array
    {
        return EnumDataProvider::tagCases(Voids::class, 'void');
    }
}
