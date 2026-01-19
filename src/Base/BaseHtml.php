<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Base;

use BackedEnum;
use UIAwesome\Html\Helper\{Attributes, Encode};
use UIAwesome\Html\Interop\{BlockInterface, InlineInterface, VoidInterface};

/**
 * Base class for HTML tag rendering and element generation.
 *
 * Provides static helpers for rendering opening tags, closing tags, and full elements using backed-enum tag values.
 * Attribute arrays are rendered via {@see Attributes::render()}, and content can be encoded via
 * {@see Encode::content()} when requested.
 *
 * Intended for helper and facade classes that expose a consistent rendering API for block, inline, and void tag types.
 *
 * Key features.
 * - Accepts backed-enum tags for block, inline, and void elements.
 * - Encodes content via {@see Encode::content()} when `$encode` is `true`.
 * - Formats block element output with line breaks and predictable empty-content handling.
 * - Provides static helpers for `begin()`, `end()`, `element()`, `inline()`, and `void()`.
 * - Renders attribute arrays via {@see Attributes::render()}.
 * - Selects rendering strategy based on `VoidInterface` and `InlineInterface` tag contracts.
 *
 * {@see BlockInterface} for contract details.
 * {@see InlineInterface} for contract details.
 * {@see VoidInterface} for contract details.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Void_element
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#main_root
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#table_content
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseHtml
{
    /**
     * Begins a block-level HTML tag with rendered attributes.
     *
     * Generates the opening tag string for the specified tag type, including rendered attributes.
     *
     * @param BlockInterface $tag Tag enumeration instance.
     * @param array $attributes Associative array of HTML attributes.
     *
     * @return string Rendered opening tag string with attributes.
     *
     * {@see \UIAwesome\Html\Interop\Block} for valid block-level tags.
     * {@see \UIAwesome\Html\Interop\Lists} for valid list-level tags.
     * {@see \UIAwesome\Html\Interop\Root} for valid root-level tags.
     * {@see \UIAwesome\Html\Interop\Table} for valid table-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * Html::begin(\UIAwesome\Html\Interop\Block::DIV, ['class' => 'container']);
     * Html::begin(\UIAwesome\Html\Interop\Lists::UL, ['class' => 'list']);
     * Html::begin(\UIAwesome\Html\Interop\Root::HTML, ['lang' => 'en']);
     * Html::begin(\UIAwesome\Html\Interop\Table::TABLE, ['class' => 'table']);
     * ```
     */
    public static function begin(BlockInterface $tag, array $attributes = []): string
    {
        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>\n";
    }

    /**
     * Renders a complete HTML element with content and attributes.
     *
     * Handles block-level, inline-level, and void-level tag types, encoding content if specified, and rendering
     * attributes as needed.
     *
     * @param BackedEnum $tag Tag enumeration instance.
     * @param string $content Content to be rendered inside the tag.
     * @param array $attributes Associative array of HTML attributes.
     * @param bool $encode Whether to encode the content for HTML output.
     *
     * @return string Rendered HTML element string.
     *
     * {@see \UIAwesome\Html\Interop\Block} for valid block-level tags.
     * {@see \UIAwesome\Html\Interop\Inline} for valid inline-level tags.
     * {@see \UIAwesome\Html\Interop\Lists} for valid list-level tags.
     * {@see \UIAwesome\Html\Interop\Root} for valid root-level tags.
     * {@see \UIAwesome\Html\Interop\Table} for valid table-level tags.
     * {@see \UIAwesome\Html\Interop\Void} for valid void-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * Html::element(\UIAwesome\Html\Interop\Block::DIV, 'Hello, World!', ['class' => 'container'], true);
     * Html::element(\UIAwesome\Html\Interop\Inline::SPAN, 'Hello, World!', ['class' => 'highlight'], false);
     * Html::element(\UIAwesome\Html\Interop\Void::IMG, '', ['src' => 'image.png', 'alt' => 'An image']);
     * ```
     */
    public static function element(
        BackedEnum $tag,
        string $content,
        array $attributes = [],
        bool $encode = false,
    ): string {
        if ($tag instanceof VoidInterface) {
            return self::void($tag, $attributes);
        }

        if ($tag instanceof InlineInterface) {
            return self::inline($tag, $content, $attributes, $encode);
        }

        if ($encode) {
            $content = Encode::content($content);
        }

        $renderAttributes = Attributes::render($attributes);

        if ($content === '') {
            return "<{$tag->value}{$renderAttributes}>\n</{$tag->value}>";
        }

        return "<{$tag->value}{$renderAttributes}>\n{$content}\n</{$tag->value}>";
    }

    /**
     * Ends a block-level HTML tag.
     *
     * Generates the closing tag string for the specified tag type.
     *
     * @param BlockInterface $tag Tag enumeration instance.
     *
     * @return string Rendered closing tag string.
     *
     * {@see \UIAwesome\Html\Interop\Block} for valid block-level tags.
     * {@see \UIAwesome\Html\Interop\Lists} for valid list-level tags.
     * {@see \UIAwesome\Html\Interop\Root} for valid root-level tags.
     * {@see \UIAwesome\Html\Interop\Table} for valid table-level tags.
     *
     * Usage example:
     * ```php
     * Html::end(\UIAwesome\Html\Interop\Block::DIV);
     * Html::end(\UIAwesome\Html\Interop\Lists::UL);
     * Html::end(\UIAwesome\Html\Interop\Root::HTML);
     * Html::end(\UIAwesome\Html\Interop\Table::TABLE);
     * ```
     */
    public static function end(BlockInterface $tag): string
    {
        return "\n</{$tag->value}>";
    }

    /**
     * Renders an inline-level HTML element with content and attributes.
     *
     * Encodes content if specified and renders attributes for the inline tag.
     *
     * @param InlineInterface $tag Inline tag enumeration instance.
     * @param string $content Content to be rendered inside the tag.
     * @param array $attributes Associative array of HTML attributes.
     * @param bool $encode Whether to encode the content for HTML output.
     *
     * @return string Rendered inline HTML element string.
     *
     * {@see \UIAwesome\Html\Interop\Inline} for valid inline-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * Html::inline(\UIAwesome\Html\Interop\Inline::SPAN, 'Hello, World!', ['class' => 'highlight']);
     * Html::inline(\UIAwesome\Html\Interop\Inline::A, '<Click Here>', ['href' => '#'], true);
     * ```
     */
    public static function inline(
        InlineInterface $tag,
        string $content,
        array $attributes = [],
        bool $encode = false,
    ): string {
        if ($encode) {
            $content = Encode::content($content);
        }

        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>{$content}</{$tag->value}>";
    }

    /**
     * Renders a void-level (self-closing) HTML element with attributes.
     *
     * Generates the tag string for void elements, including rendered attributes.
     *
     * @param VoidInterface $tag Void tag enumeration instance.
     * @param array $attributes Associative array of HTML attributes.
     *
     * @return string Rendered void HTML element string.
     *
     * {@see \UIAwesome\Html\Interop\Void} for valid void-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * Html::void(\UIAwesome\Html\Interop\Void::IMG, ['src' => 'image.png', 'alt' => 'An image']);
     * ```
     */
    public static function void(VoidInterface $tag, array $attributes = []): string
    {
        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>";
    }
}
