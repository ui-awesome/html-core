<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests;

use PHPForge\Support\LineEndingNormalizer;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Tests\Support\Provider\Tag\{
    BlockProvider,
    InlineProvider,
    ListsProvider,
    RootProvider,
    TableProvider,
    VoidProvider,
};
use UIAwesome\Html\Interop\{Block, BlockInterface, Inline, InlineInterface, VoidInterface, Voids};

/**
 * Unit tests for {@see Html} rendering and tag validation.
 *
 * Verifies rendered output, content encoding, and attribute normalization behavior for {@see Html}.
 *
 * Test coverage.
 * - Encodes content when requested for `Html::element()` and `Html::inline()`.
 * - Escapes special characters in attribute values.
 * - Filters empty string attribute values while preserving `null` values.
 * - Normalizes and renders complex attribute structures (for example `class` arrays and nested `data` arrays).
 * - Renders begin/end output for block, list, root, and table tags via enum providers.
 * - Renders inline and void tags with representative attribute sets, including boolean attributes.
 * - Retains newline and tab characters within attribute values.
 *
 * {@see Html} for implementation details.
 * {@see BlockProvider}, {@see InlineProvider}, {@see ListsProvider}, {@see RootProvider}, {@see TableProvider},
 * {@see VoidProvider} for test case data providers.
 * {@see TestSupport} for assertion utilities.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('html')]
final class HtmlTest extends TestCase
{
    #[DataProviderExternal(BlockProvider::class, 'blockTags')]
    public function testRenderBeginWithBlockTag(BlockInterface $tag, string $expectedTagName): void
    {
        self::assertEquals(
            "<{$expectedTagName}>\n",
            Html::begin($tag),
            "Html begin '<{$expectedTagName}>' block tag should match expected output.",
        );
    }

    #[DataProviderExternal(ListsProvider::class, 'listTags')]
    public function testRenderBeginWithListTag(BlockInterface $tag, string $expectedTagName): void
    {
        self::assertEquals(
            "<{$expectedTagName}>\n",
            Html::begin($tag),
            "Html begin '<{$expectedTagName}>' list tag should match expected output.",
        );
    }

    #[DataProviderExternal(RootProvider::class, 'rootTags')]
    public function testRenderBeginWithRootTag(BlockInterface $tag, string $expectedTagName): void
    {
        self::assertEquals(
            "<{$expectedTagName}>\n",
            Html::begin($tag),
            "Html begin '<{$expectedTagName}>' root tag should match expected output.",
        );
    }

    #[DataProviderExternal(TableProvider::class, 'tableTags')]
    public function testRenderBeginWithTableTag(BlockInterface $tag, string $expectedTagName): void
    {
        self::assertEquals(
            "<{$expectedTagName}>\n",
            Html::begin($tag),
            "Html begin '<{$expectedTagName}>' table tag should match expected output.",
        );
    }

    public function testRenderElementWithAriaAttributes(): void
    {
        $content = 'Accessible content';
        $attributes = [
            'aria-label' => 'Main navigation',
            'aria-hidden' => 'false',
            'aria-describedby' => 'description-id',
        ];

        self::assertEquals(
            <<<HTML
            <div aria-label="Main navigation" aria-hidden="false" aria-describedby="description-id">
            Accessible content
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Block::DIV, $content, $attributes),
            ),
            "Html element '<div>' with ARIA attributes should match expected output.",
        );
    }

    public function testRenderElementWithAttributeValuesContainingNewlines(): void
    {
        $content = 'content';
        $attributes = [
            'title' => "Line 1\nLine 2\nLine 3",
            'data-info' => "First\r\nSecond",
        ];

        $result = Html::element(Block::DIV, $content, $attributes);

        self::assertStringContainsString(
            'title="Line 1',
            $result,
            "Html element '<div>' with newlines in attribute values should contain title attribute.",
        );
        self::assertStringContainsString(
            'data-info="First',
            $result,
            "Html element '<div>' with newlines in attribute values should contain data-info attribute.",
        );
    }

    public function testRenderElementWithAttributeValuesContainingTabs(): void
    {
        $content = 'content';
        $attributes = [
            'title' => "Text\twith\ttabs",
            'data-info' => "\tLeading tab",
        ];

        $result = Html::element(Block::DIV, $content, $attributes);

        self::assertStringContainsString(
            'title="Text',
            $result,
            "Html element '<div>' with tabs in attribute values should contain title attribute.",
        );
        self::assertStringContainsString(
            'data-info="',
            $result,
            "Html element '<div>' with tabs in attribute values should contain data-info attribute.",
        );
    }

    public function testRenderElementWithBlockTag(): void
    {
        $content = '<span>Test Content</span>';
        $attributes = ['class' => 'test-class'];

        self::assertEquals(
            <<<HTML
            <div class="test-class">
            <span>Test Content</span>
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Block::DIV, $content, $attributes),
            ),
            "Html element '<div>' with content and attributes should match expected output.",
        );

        self::assertEquals(
            <<<HTML
            <div class="test-class">
            &lt;span&gt;Test Content&lt;/span&gt;
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Block::DIV, $content, $attributes, true),
            ),
            "Html element '<div>' with encoded content and attributes should match expected output.",
        );
    }

    public function testRenderElementWithBlockTagEmptyContent(): void
    {
        $attributes = ['class' => 'empty-content'];

        self::assertEquals(
            <<<HTML
            <div class="empty-content">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Block::DIV, '', $attributes),
            ),
            "Html element '<div>' with empty content and attributes should match expected output.",
        );
    }

    public function testRenderElementWithBooleanAttributes(): void
    {
        $content = 'Button text';
        $attributes = [
            'disabled' => true,
            'readonly' => false,
            'checked' => true,
        ];

        $result = Html::element(Inline::BUTTON, $content, $attributes);

        self::assertStringContainsString(
            'disabled',
            $result,
            "Html element '<button>' should contain disabled attribute when value is true.",
        );
        self::assertStringContainsString(
            'checked',
            $result,
            "Html element '<button>' should contain checked attribute when value is true.",
        );
        self::assertStringNotContainsString(
            'readonly',
            $result,
            "Html element '<button>' should not contain readonly attribute when value is false.",
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

        self::assertEquals(
            <<<HTML
            <div class="class-1 class-2" data-id="123" data-name="test">
            content
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Block::DIV, $content, $attributes),
            ),
            "Html element '<div>' with complex attribute structures should match expected output.",
        );
    }

    public function testRenderElementWithEmptyAttributesArray(): void
    {
        $content = 'content';

        self::assertEquals(
            <<<HTML
            <div>
            content
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Block::DIV, $content, []),
            ),
            "Html element '<div>' with content and empty attributes array should match expected output.",
        );
    }

    public function testRenderElementWithEmptyStringAttributeValue(): void
    {
        $content = 'content';
        $attributes = [
            'id' => '',
            'class' => '',
            'title' => '',
        ];

        $result = Html::element(Block::DIV, $content, $attributes);

        self::assertStringNotContainsString(
            'id=',
            $result,
            "Html element '<div>' should filter out empty string attribute values.",
        );
        self::assertStringNotContainsString(
            'class=',
            $result,
            "Html element '<div>' should filter out empty string attribute values.",
        );
        self::assertStringNotContainsString(
            'title=',
            $result,
            "Html element '<div>' should filter out empty string attribute values.",
        );
    }

    public function testRenderElementWithInlineTag(): void
    {
        $content = '<mark>inline</mark>';
        $attributes = ['id' => 'inline'];

        self::assertEquals(
            <<<HTML
            <span id="inline"><mark>inline</mark></span>
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Inline::SPAN, $content, $attributes),
            ),
            "Html element '<span>' with content and attributes should match expected output.",
        );

        self::assertEquals(
            <<<HTML
            <span id="inline">&lt;mark&gt;inline&lt;/mark&gt;</span>
            HTML,
            Html::element(Inline::SPAN, $content, $attributes, true),
            "Html element '<span>' with encoded content and attributes should match expected output.",
        );
    }

    public function testRenderElementWithLargeAttributeValue(): void
    {
        $content = 'content';
        $largeValue = str_repeat('A', 10000);
        $attributes = [
            'data-large' => $largeValue,
        ];

        $expected = <<<HTML
        <div data-large="{$largeValue}">
        content
        </div>
        HTML;

        self::assertEquals(
            $expected,
            LineEndingNormalizer::normalize(
                Html::element(Block::DIV, $content, $attributes),
            ),
            "Html element '<div>' with large attribute value should match expected output.",
        );
    }

    public function testRenderElementWithNullAttributeValue(): void
    {
        $content = 'content';
        $attributes = [
            'id' => null,
            'class' => 'test-class',
        ];

        self::assertEquals(
            <<<HTML
            <div class="test-class">
            content
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Block::DIV, $content, $attributes),
            ),
            "Html element '<div>' with null attribute value should match expected output.",
        );
    }

    public function testRenderElementWithSpecialCharactersInAttributes(): void
    {
        $content = 'content';
        $attributes = [
            'title' => 'Test "quoted" value',
            'data-info' => 'Value with & ampersand',
        ];

        self::assertEquals(
            <<<HTML
            <div title="Test &quot;quoted&quot; value" data-info="Value with &amp; ampersand">
            content
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Block::DIV, $content, $attributes),
            ),
            "Html element '<div>' with special characters in attributes should match expected output.",
        );
    }

    public function testRenderElementWithVoidTag(): void
    {
        $attributes = [
            'class' => ['void'],
            'data' => ['role' => 'presentation'],
        ];

        self::assertEquals(
            <<<HTML
            <img class="void" data-role="presentation">
            HTML,
            LineEndingNormalizer::normalize(
                Html::element(Voids::IMG, '', $attributes),
            ),
            "Html element '<img>' void tag with attributes should match expected output.",
        );
    }

    #[DataProviderExternal(BlockProvider::class, 'blockTags')]
    public function testRenderEndWithBlockTag(BlockInterface $tag, string $expectedTagName): void
    {
        self::assertEquals(
            "\n</{$expectedTagName}>",
            Html::end($tag),
            "Html end '</{$expectedTagName}>' block tag should match expected output.",
        );
    }

    #[DataProviderExternal(ListsProvider::class, 'listTags')]
    public function testRenderEndWithListTag(BlockInterface $tag, string $expectedTagName): void
    {
        self::assertEquals(
            "\n</{$expectedTagName}>",
            Html::end($tag),
            "Html end '</{$expectedTagName}>' list tag should match expected output.",
        );
    }

    #[DataProviderExternal(RootProvider::class, 'rootTags')]
    public function testRenderEndWithRootTag(BlockInterface $tag, string $expectedTagName): void
    {
        self::assertEquals(
            "\n</{$expectedTagName}>",
            Html::end($tag),
            "Html end '</{$expectedTagName}>' root tag should match expected output.",
        );
    }

    #[DataProviderExternal(TableProvider::class, 'tableTags')]
    public function testRenderEndWithTableTag(BlockInterface $tag, string $expectedTagName): void
    {
        self::assertEquals(
            "\n</{$expectedTagName}>",
            Html::end($tag),
            "Html end '</{$expectedTagName}>' table tag should match expected output.",
        );
    }

    #[DataProviderExternal(InlineProvider::class, 'inlineTags')]
    public function testRenderInline(InlineInterface $tag, string $expectedTagName): void
    {
        $content = '<mark>inline</mark>';
        $attributes = ['id' => 'inline'];

        self::assertEquals(
            "<{$expectedTagName} id=\"inline\">{$content}</{$expectedTagName}>",
            Html::inline($tag, $content, $attributes),
            "Html inline '<{$expectedTagName}>' tag without encoding should match expected output.",
        );
        self::assertEquals(
            "<{$expectedTagName} id=\"inline\">&lt;mark&gt;inline&lt;/mark&gt;</{$expectedTagName}>",
            Html::inline($tag, $content, $attributes, true),
            "Html inline '<{$expectedTagName}>' tag with encoding should match expected output.",
        );
    }

    #[DataProviderExternal(VoidProvider::class, 'voidTags')]
    public function testRenderVoid(VoidInterface $tag, string $expectedTagName): void
    {
        $attributes = [
            'class' => ['void'],
            'data' => ['role' => 'presentation'],
        ];

        self::assertEquals(
            "<{$expectedTagName} class=\"void\" data-role=\"presentation\">",
            Html::void($tag, $attributes),
            "Html void '<{$expectedTagName}>' tag should match expected output.",
        );
    }

    public function testRenderVoidTagWithBooleanAttributes(): void
    {
        $attributes = [
            'disabled' => true,
            'readonly' => false,
            'required' => true,
        ];

        $result = Html::void(Voids::INPUT, $attributes);

        self::assertStringContainsString(
            'disabled',
            $result,
            "Html void '<input>' tag should contain disabled attribute when value is true.",
        );
        self::assertStringContainsString(
            'required',
            $result,
            "Html void '<input>' tag should contain required attribute when value is true.",
        );
        self::assertStringNotContainsString(
            'readonly',
            $result,
            "Html void '<input>' tag should not contain readonly attribute when value is false.",
        );
    }
}
