<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Provider;

use PHPForge\Support\EnumDataProvider;
use UIAwesome\Html\Interop\Root;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\HtmlTest} test cases.
 */
final class RootProvider
{
    /**
     * @phpstan-return array<string, array{UnitEnum, string}>
     */
    public static function rootTags(): array
    {
        return EnumDataProvider::tagCases(Root::class, 'root');
    }
}
