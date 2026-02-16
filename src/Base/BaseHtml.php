<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Base;

use BackedEnum;
use UIAwesome\Html\Helper\{Attributes, Encode};
use UIAwesome\Html\Interop\{BlockInterface, InlineInterface, VoidInterface};

/**
 * Provides the base implementation for rendering block, inline, and void HTML tags.
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
     * Returns the opening tag for a block element.
     *
     * Usage example:
     * ```php
     * \UIAwesome\Html\Core\Html::begin(
     *     \UIAwesome\Html\Interop\Block::DIV,
     *     ['class' => 'container'],
     * );
     * ```
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
     */
    public static function begin(BlockInterface $tag, array $attributes = []): string
    {
        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>\n";
    }

    /**
     * Returns a complete HTML element `string`.
     *
     * Usage example:
     * ```php
     * \UIAwesome\Html\Core\Html::element(
     *     \UIAwesome\Html\Interop\Inline::SPAN,
     *     '<Click Here>',
     *     ['class' => 'link'],
     *     true,
     * );
     * ```
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
     * Returns the closing tag for a block element.
     *
     * Usage example:
     * ```php
     * \UIAwesome\Html\Core\Html::end(\UIAwesome\Html\Interop\Block::DIV);
     * ```
     *
     * @param BlockInterface $tag Tag enumeration instance.
     *
     * @return string Rendered closing tag string.
     *
     * {@see \UIAwesome\Html\Interop\Block} for valid block-level tags.
     * {@see \UIAwesome\Html\Interop\Lists} for valid list-level tags.
     * {@see \UIAwesome\Html\Interop\Root} for valid root-level tags.
     * {@see \UIAwesome\Html\Interop\Table} for valid table-level tags.
     */
    public static function end(BlockInterface $tag): string
    {
        return "\n</{$tag->value}>";
    }

    /**
     * Returns an inline HTML element `string`.
     *
     * Usage example:
     * ```php
     * \UIAwesome\Html\Core\Html::inline(
     *     \UIAwesome\Html\Interop\Inline::A,
     *     '<Click Here>',
     *     ['href' => '#'],
     *     true,
     * );
     * ```
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
     * Returns a void HTML element `string`.
     *
     * Usage example:
     * ```php
     * \UIAwesome\Html\Core\Html::void(
     *     \UIAwesome\Html\Interop\Void::IMG,
     *     ['src' => 'image.png', 'alt' => 'An image'],
     * );
     * ```
     *
     * @param VoidInterface $tag Void tag enumeration instance.
     * @param array $attributes Associative array of HTML attributes.
     *
     * @return string Rendered void HTML element string.
     *
     * {@see \UIAwesome\Html\Interop\Void} for valid void-level tags.
     *
     * @phpstan-param mixed[] $attributes
     */
    public static function void(VoidInterface $tag, array $attributes = []): string
    {
        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>";
    }
}
