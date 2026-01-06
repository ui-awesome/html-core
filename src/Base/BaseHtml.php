<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Base;

use BackedEnum;
use UIAwesome\Html\Helper\{Attributes, Encode};
use UIAwesome\Html\Interop\{BlockInterface, InlineInterface, VoidInterface};

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
 * - Unified rendering for block-level, inline-level, and void-level tag types.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Void_element
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#main_root
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#table_content
 * {@see BlockInterface} for contract details.
 * {@see InlineInterface} for contract details.
 * {@see VoidInterface} for contract details.
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
     * {@see \UIAwesome\Html\Core\Tag\Block} for valid block-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Lists} for valid list-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Root} for valid root-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Table} for valid table-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * // block-level tag
     * Html::begin(\UIAwesome\Html\Core\Tag\Block::DIV, ['class' => 'container']);
     *
     * // list-level tag
     * Html::begin(\UIAwesome\Html\Core\Tag\Lists::UL, ['class' => 'list']);
     *
     * // root-level tag
     * Html::begin(\UIAwesome\Html\Core\Tag\Root::HTML, ['lang' => 'en']);
     *
     * // table-level tag
     * Html::begin(\UIAwesome\Html\Core\Tag\Table::TABLE, ['class' => 'table']);
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
     * {@see \UIAwesome\Html\Core\Tag\Block} for valid block-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Inline} for valid inline-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Lists} for valid list-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Root} for valid root-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Table} for valid table-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Void} for valid void-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * // block-level tag
     * Html::element(\UIAwesome\Html\Core\Tag\Block::DIV, 'Hello, World!', ['class' => 'container'], true);
     *
     * // inline-level tag
     * Html::element(\UIAwesome\Html\Core\Tag\Inline::SPAN, 'Hello, World!', ['class' => 'highlight'], false);
     *
     * // void-level tag
     * Html::element(\UIAwesome\Html\Core\Tag\Void::IMG, '', ['src' => 'image.png', 'alt' => 'An image']);
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
     * {@see \UIAwesome\Html\Core\Tag\Block} for valid block-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Lists} for valid list-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Root} for valid root-level tags.
     * {@see \UIAwesome\Html\Core\Tag\Table} for valid table-level tags.
     *
     * Usage example:
     * ```php
     * // block-level tag
     * Html::end(\UIAwesome\Html\Core\Tag\Block::DIV);
     *
     * // list-level tag
     * Html::end(\UIAwesome\Html\Core\Tag\Lists::UL);
     *
     * // root-level tag
     * Html::end(\UIAwesome\Html\Core\Tag\Root::HTML);
     *
     * // table-level tag
     * Html::end(\UIAwesome\Html\Core\Tag\Table::TABLE);
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
     * {@see \UIAwesome\Html\Core\Tag\Inline} for valid inline-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * // without content encoding
     * Html::inline(\UIAwesome\Html\Core\Tag\Inline::SPAN, 'Hello, World!', ['class' => 'highlight']);
     *
     * // with content encoding
     * Html::inline(\UIAwesome\Html\Core\Tag\Inline::A, '<Click Here>', ['href' => '#'], true);
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
     * {@see \UIAwesome\Html\Core\Tag\Void} for valid void-level tags.
     *
     * @phpstan-param mixed[] $attributes
     *
     * Usage example:
     * ```php
     * Html::void(\UIAwesome\Html\Core\Tag\Void::IMG, ['src' => 'image.png', 'alt' => 'An image']);
     * ```
     */
    public static function void(VoidInterface $tag, array $attributes = []): string
    {
        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>";
    }
}
