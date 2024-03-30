<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests;

use PHPForge\Support\Assert;
use UIAwesome\Html\Core\HTMLBuilder;

final class RenderTest extends \PHPUnit\Framework\TestCase
{
    public function testBegin(): void
    {
        $this->assertSame('<div>', HTMLBuilder::beginTag('div'));
        $this->assertSame('<div class="class">', HTMLBuilder::beginTag('div', ['class' => 'class']));
    }

    /**
     * @dataProvider UIAwesome\Html\Core\Tests\Provider\TagProvider::create
     *
     * @param string $tagName Tag name.
     * @param string $content Tag content.
     * @param array $attributes Tag attributes.
     * @param string $expected Expected result.
     */
    public function testCreate(string $tagName, string $content, array $attributes, string $expected): void
    {
        Assert::equalsWithoutLE($expected, HTMLBuilder::createTag($tagName, $content, $attributes));
    }

    public function testEnd(): void
    {
        $this->assertSame('</div>', HTMLBuilder::endTag('div'));
    }
}
