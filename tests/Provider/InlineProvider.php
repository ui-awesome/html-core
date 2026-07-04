<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Provider;

use PHPForge\Support\EnumDataProvider;
use UIAwesome\Html\Interop\Inline;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\HtmlTest} test cases.
 */
final class InlineProvider
{
    /**
     * @phpstan-return array<string, array{UnitEnum, string}>
     */
    public static function inlineTags(): array
    {
        return EnumDataProvider::tagCases(Inline::class, 'inline');
    }
}
