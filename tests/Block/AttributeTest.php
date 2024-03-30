<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Block;

use PHPForge\Support\Assert;
use UIAwesome\Html\Core\Block;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class AttributeTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body class="value">
            </body>
            HTML,
            Block::widget()->attributes(['class' => 'value'])->tagName('body')->render()
        );
    }

    public function testClass(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body class="value">
            </body>
            HTML,
            Block::widget()->class('value')->tagName('body')->render()
        );
    }

    public function testContent(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body>
            value
            </body>
            HTML,
            Block::widget()->content('value')->tagName('body')->render()
        );
    }

    public function testDataAttributes(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body data-value="value">
            </body>
            HTML,
            Block::widget()->dataAttributes(['value' => 'value'])->tagName('body')->render()
        );
    }

    public function testId(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body id="value">
            </body>
            HTML,
            Block::widget()->id('value')->tagName('body')->render()
        );
    }

    public function testLang(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body lang="value">
            </body>
            HTML,
            Block::widget()->lang('value')->tagName('body')->render()
        );
    }

    public function testStyle(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body style="value">
            </body>
            HTML,
            Block::widget()->style('value')->tagName('body')->render()
        );
    }

    public function testTitle(): void
    {
        Assert::equalsWithoutLE(
            <<<HTML
            <body title="value">
            </body>
            HTML,
            Block::widget()->title('value')->tagName('body')->render()
        );
    }
}
