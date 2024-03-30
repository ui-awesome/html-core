<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Block;

use PHPForge\Support\Assert;
use UIAwesome\Html\Core\Block;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class CustomMethodTest extends \PHPUnit\Framework\TestCase
{
    public function testBegin(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body>
            HTML,
            Block::widget()->tagName('body')->begin()
        );
    }

    public function testEnd(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            </body>
            HTML,
            Block::end()
        );
    }

    public function testRender(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body>
            </body>
            HTML,
            Block::widget()->tagName('body')->render()
        );
    }
}
