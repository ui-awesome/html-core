<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Tag\{Block, Inline, Lists, Root, Table, Voids};
use UIAwesome\Html\Core\Tests\Support\Provider\Tag\{
    BlockProvider,
    InlineProvider,
    ListsProvider,
    RootProvider,
    TableProvider,
    VoidProvider,
};
use UIAwesome\Html\Core\Tests\Support\TestSupport;

/**
 * Test suite for {@see Html} rendering logic and tag validation.
 *
 * Validates the correct handling and output of HTML tags according to the HTML Living Standard specification.
 *
 * Ensures proper rendering, immutability, and validation of block, inline, list, root, table and void elements,
 * supporting UnitEnum tag names.
 *
 * Test coverage.
 * - Accurate rendering of block, inline, list, root, table and void HTML tags.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Exception handling for invalid tag names and element types.
 * - Immutability of the API when rendering or validating tags.
 * - Proper assignment and normalization of tag names.
 *
 * {@see BlockProvider}, {@see InlineProvider}, {@see ListsProvider}, {@see RootProvider}, {@see TableProvider},
 * {@see VoidProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('html')]
final class HtmlTest extends TestCase
{
    use TestSupport;

    #[DataProviderExternal(BlockProvider::class, 'blockTags')]
    public function testRenderBeginWithBlockTag(Block $tag, string $expectedTagName): void
    {
        self::equalsWithoutLE(
            "<{$expectedTagName}>\n",
            Html::begin($tag),
            "Html begin '<{$expectedTagName}>' block tag should match expected output.",
        );
    }

    #[DataProviderExternal(ListsProvider::class, 'listTags')]
    public function testRenderBeginWithListTag(Lists $tag, string $expectedTagName): void
    {
        self::equalsWithoutLE(
            "<{$expectedTagName}>\n",
            Html::begin($tag),
            "Html begin '<{$expectedTagName}>' list tag should match expected output.",
        );
    }

    #[DataProviderExternal(RootProvider::class, 'rootTags')]
    public function testRenderBeginWithRootTag(Root $tag, string $expectedTagName): void
    {
        self::equalsWithoutLE(
            "<{$expectedTagName}>\n",
            Html::begin($tag),
            "Html begin '<{$expectedTagName}>' root tag should match expected output.",
        );
    }

    #[DataProviderExternal(TableProvider::class, 'tableTags')]
    public function testRenderBeginWithTableTag(Table $tag, string $expectedTagName): void
    {
        self::equalsWithoutLE(
            "<{$expectedTagName}>\n",
            Html::begin($tag),
            "Html begin '<{$expectedTagName}>' table tag should match expected output.",
        );
    }

    public function testRenderElementWithBlockTag(): void
    {
        $content = '<span>Test Content</span>';
        $attributes = ['class' => 'test-class'];

        self::equalsWithoutLE(
            <<<HTML
            <div class="test-class">
            <span>Test Content</span>
            </div>
            HTML,
            Html::element(Block::DIV, $content, $attributes),
            "Html element '<div>' with content and attributes should match expected output.",
        );

        self::equalsWithoutLE(
            <<<HTML
            <div class="test-class">
            &lt;span&gt;Test Content&lt;/span&gt;
            </div>
            HTML,
            Html::element(Block::DIV, $content, $attributes, true),
            "Html element '<div>' with encoded content and attributes should match expected output.",
        );
    }

    public function testRenderElementWithBlockTagEmptyContent(): void
    {
        $attributes = ['class' => 'empty-content'];

        self::equalsWithoutLE(
            <<<HTML
            <div class="empty-content">
            </div>
            HTML,
            Html::element(Block::DIV, '', $attributes),
            "Html element '<div>' with empty content and attributes should match expected output.",
        );
    }

    public function testRenderElementWithComplexAttributeStructures(): void
    {
        $content = 'content';
        $attributes = [
            'class' => [
                'class-1',
                'class-2',
            ],
            'data' => [
                'id' => '123',
                'name' => 'test',
            ],
        ];

        self::equalsWithoutLE(
            <<<HTML
            <div class="class-1 class-2" data-id="123" data-name="test">
            content
            </div>
            HTML,
            Html::element(Block::DIV, $content, $attributes),
            "Html element '<div>' with complex attribute structures should match expected output.",
        );
    }

    public function testRenderElementWithEmptyAttributesArray(): void
    {
        $content = 'content';

        self::equalsWithoutLE(
            <<<HTML
            <div>
            content
            </div>
            HTML,
            Html::element(Block::DIV, $content, []),
            "Html element '<div>' with content and empty attributes array should match expected output.",
        );
    }

    public function testRenderElementWithInlineTag(): void
    {
        $content = '<mark>inline</mark>';
        $attributes = ['id' => 'inline'];

        self::equalsWithoutLE(
            <<<HTML
            <span id="inline"><mark>inline</mark></span>
            HTML,
            Html::element(Inline::SPAN, $content, $attributes),
            "Html element '<span>' with content and attributes should match expected output.",
        );

        self::equalsWithoutLE(
            <<<HTML
            <span id="inline">&lt;mark&gt;inline&lt;/mark&gt;</span>
            HTML,
            Html::element(Inline::SPAN, $content, $attributes, true),
            "Html element '<span>' with encoded content and attributes should match expected output.",
        );
    }

    public function testRenderElementWithSpecialCharactersInAttributes(): void
    {
        $content = 'content';
        $attributes = [
            'title' => 'Test "quoted" value',
            'data-info' => 'Value with & ampersand',
        ];

        self::equalsWithoutLE(
            <<<HTML
            <div title="Test &quot;quoted&quot; value" data-info="Value with &amp; ampersand">
            content
            </div>
            HTML,
            Html::element(Block::DIV, $content, $attributes),
            "Html element '<div>' with special characters in attributes should match expected output.",
        );
    }

    public function testRenderElementWithVoidTag(): void
    {
        $attributes = [
            'class' => ['void'],
            'data' => ['role' => 'presentation'],
        ];

        self::equalsWithoutLE(
            <<<HTML
            <img class="void" data-role="presentation">
            HTML,
            Html::element(Voids::IMG, '', $attributes),
            "Html element '<img>' void tag with attributes should match expected output.",
        );
    }

    #[DataProviderExternal(BlockProvider::class, 'blockTags')]
    public function testRenderEndWithBlockTag(Block $tag, string $expectedTagName): void
    {
        self::equalsWithoutLE(
            "\n</{$expectedTagName}>",
            Html::end($tag),
            "Html end '</{$expectedTagName}>' block tag should match expected output.",
        );
    }

    #[DataProviderExternal(ListsProvider::class, 'listTags')]
    public function testRenderEndWithListTag(Lists $tag, string $expectedTagName): void
    {
        self::equalsWithoutLE(
            "\n</{$expectedTagName}>",
            Html::end($tag),
            "Html end '</{$expectedTagName}>' list tag should match expected output.",
        );
    }

    #[DataProviderExternal(RootProvider::class, 'rootTags')]
    public function testRenderEndWithRootTag(Root $tag, string $expectedTagName): void
    {
        self::equalsWithoutLE(
            "\n</{$expectedTagName}>",
            Html::end($tag),
            "Html end '</{$expectedTagName}>' root tag should match expected output.",
        );
    }

    #[DataProviderExternal(TableProvider::class, 'tableTags')]
    public function testRenderEndWithTableTag(Table $tag, string $expectedTagName): void
    {
        self::equalsWithoutLE(
            "\n</{$expectedTagName}>",
            Html::end($tag),
            "Html end '</{$expectedTagName}>' table tag should match expected output.",
        );
    }

    #[DataProviderExternal(InlineProvider::class, 'inlineTags')]
    public function testRenderInline(Inline $tag, string $expectedTagName): void
    {
        $content = '<mark>inline</mark>';
        $attributes = ['id' => 'inline'];

        self::equalsWithoutLE(
            "<{$expectedTagName} id=\"inline\">{$content}</{$expectedTagName}>",
            Html::inline($tag, $content, $attributes),
            "Html inline '<{$expectedTagName}>' tag without encoding should match expected output.",
        );
        self::equalsWithoutLE(
            "<{$expectedTagName} id=\"inline\">&lt;mark&gt;inline&lt;/mark&gt;</{$expectedTagName}>",
            Html::inline($tag, $content, $attributes, true),
            "Html inline '<{$expectedTagName}>' tag with encoding should match expected output.",
        );
    }

    #[DataProviderExternal(VoidProvider::class, 'voidTags')]
    public function testRenderVoid(Voids $tag, string $expectedTagName): void
    {
        $attributes = [
            'class' => ['void'],
            'data' => ['role' => 'presentation'],
        ];

        self::equalsWithoutLE(
            "<{$expectedTagName} class=\"void\" data-role=\"presentation\">",
            Html::void($tag, $attributes),
            "Html void '<{$expectedTagName}>' tag should match expected output.",
        );
    }
}
