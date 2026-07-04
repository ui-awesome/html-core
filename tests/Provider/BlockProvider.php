<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Provider;

use PHPForge\Support\EnumDataProvider;
use UIAwesome\Html\Interop\Block;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\HtmlTest} test cases.
 */
final class BlockProvider
{
    /**
     * @phpstan-return array<string, array{UnitEnum, string}>
     */
    public static function blockTags(): array
    {
        return EnumDataProvider::tagCases(Block::class, 'block');
    }
}
