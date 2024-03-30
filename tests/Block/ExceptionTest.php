<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Block;

use UIAwesome\Html\Core\Block;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testWithoutTagName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');

        Block::widget()->render();
    }
}
