<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Base;

use BackedEnum;
use UIAwesome\Html\Core\Tag\{Block, Inline, Lists, Root, Table, Voids};
use UIAwesome\Html\Helper\{Attributes, Encode};

/**
 * Base class for standards-compliant HTML tag rendering and element generation.
 *
 * Provides a unified, immutable API for creating, rendering, and managing HTML tags, supporting advanced attribute
 * handling, encoding, and tag type abstraction for modern web applications.
 *
 * Designed for use in HTML helpers, tag builders, and view renderers, this class ensures predictable, secure, and
 * extensible HTML output, integrating with attribute and encoding systems for robust UI component development.
 *
 * Key features.
 * - Attribute array processing and encoding for safe HTML output.
 * - Immutable, stateless design for safe reuse.
 * - Integration-ready for tag, attribute, and encoding helpers.
 * - Support `UnitEnum` tag types for flexible API design.
 * - Type-safe, static methods for tag and content rendering.
 * - Unified rendering for block, inline, void, and list HTML tags.
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
     * Begins a block, list, root, or table HTML tag with rendered attributes.
     *
     * Generates the opening tag string for the specified tag type, including rendered attributes.
     *
     * @param Block|Lists|Root|Table $tag Tag enumeration instance.
     * @param array $attributes Associative array of HTML attributes.
     *
     * @return string Rendered opening tag string with attributes.
     *
     * {@see Block} for valid block-level tags.
     * {@see Lists} for valid list-level tags.
     * {@see Root} for valid root-level tags.
     * {@see Table} for valid table-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * // block-level tag
     * Html::begin(Block::DIV, ['class' => 'container']);
     *
     * // list-level tag
     * Html::begin(Lists::UL, ['class' => 'list']);
     *
     * // root-level tag
     * Html::begin(Root::HTML, ['lang' => 'en']);
     *
     * // table-level tag
     * Html::begin(Table::TABLE, ['class' => 'table']);
     * ```
     */
    public static function begin(Block|Lists|Root|Table $tag, array $attributes = []): string
    {
        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>\n";
    }

    /**
     * Renders a complete HTML element with content and attributes.
     *
     * Handles block, inline, and void tag types, encoding content if specified, and rendering attributes as needed.
     *
     * @param BackedEnum $tag Tag enumeration instance.
     * @param string $content Content to be rendered inside the tag.
     * @param array $attributes Associative array of HTML attributes.
     * @param bool $encode Whether to encode the content for HTML output.
     *
     * @return string Rendered HTML element string.
     *
     * {@see Block} for valid block-level tags.
     * {@see Inline} for valid inline-level tags.
     * {@see Lists} for valid list-level tags.
     * {@see Root} for valid root-level tags.
     * {@see Table} for valid table-level tags.
     * {@see Voids} for valid void-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * // block-level tag
     * Html::element(Block::DIV, 'Hello, World!', ['class' => 'container'], true);
     *
     * // inline-level tag
     * Html::element(Inline::SPAN, 'Hello, World!', ['class' => 'highlight'], false);
     *
     * // void-level tag
     * Html::element(Voids::IMG, '', ['src' => 'image.png', 'alt' => 'An image']);
     * ```
     */
    public static function element(
        BackedEnum $tag,
        string $content,
        array $attributes = [],
        bool $encode = false,
    ): string {
        if ($tag instanceof Voids) {
            return self::void($tag, $attributes);
        }

        if ($tag instanceof Inline) {
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
     * Ends a block, list, root, or table HTML tag.
     *
     * Generates the closing tag string for the specified tag type.
     *
     * @param Block|Lists|Root|Table $tag Tag enumeration instance.
     *
     * @return string Rendered closing tag string.
     *
     * {@see Block} for valid block-level tags.
     * {@see Lists} for valid list-level tags.
     * {@see Root} for valid root-level tags.
     * {@see Table} for valid table-level tags.
     *
     * Usage example:
     * ```php
     * // block-level tag
     * Html::end(Block::DIV);
     *
     * // list-level tag
     * Html::end(Lists::UL);
     *
     * // root-level tag
     * Html::end(Root::HTML);
     *
     * // table-level tag
     * Html::end(Table::TABLE);
     * ```
     */
    public static function end(Block|Lists|Root|Table $tag): string
    {
        return "\n</{$tag->value}>";
    }

    /**
     * Renders an inline HTML element with content and attributes.
     *
     * Encodes content if specified and renders attributes for the inline tag.
     *
     * @param Inline $tag Inline tag enumeration instance.
     * @param string $content Content to be rendered inside the tag.
     * @param array $attributes Associative array of HTML attributes.
     * @param bool $encode Whether to encode the content for HTML output.
     *
     * @return string Rendered inline HTML element string.
     *
     * {@see Inline} for valid inline-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * // without content encoding
     * Html::inline(Inline::SPAN, 'Hello, World!', ['class' => 'highlight']);
     *
     * // with content encoding
     * Html::inline(Inline::A, '<Click Here>', ['href' => '#'], true);
     * ```
     */
    public static function inline(Inline $tag, string $content, array $attributes = [], bool $encode = false): string
    {
        if ($encode) {
            $content = Encode::content($content);
        }

        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>{$content}</{$tag->value}>";
    }

    /**
     * Renders a void (self-closing) HTML element with attributes.
     *
     * Generates the tag string for void elements, including rendered attributes.
     *
     * @param Voids $tag Void tag enumeration instance.
     * @param array $attributes Associative array of HTML attributes.
     *
     * @return string Rendered void HTML element string.
     *
     * {@see Voids} for valid void-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * Html::void(Voids::IMG, ['src' => 'image.png', 'alt' => 'An image']);
     * ```
     */
    public static function void(Voids $tag, array $attributes = []): string
    {
        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>";
    }
}
