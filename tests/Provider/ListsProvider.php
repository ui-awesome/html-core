<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Provider;

use PHPForge\Support\EnumDataProvider;
use UIAwesome\Html\Interop\Lists;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\HtmlTest} test cases.
 */
final class ListsProvider
{
    /**
     * @phpstan-return array<string, array{UnitEnum, string}>
     */
    public static function listTags(): array
    {
        return EnumDataProvider::tagCases(Lists::class, 'list');
    }
}
