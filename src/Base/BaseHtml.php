<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Base;

use BackedEnum;
use UIAwesome\Html\Helper\{Attributes, Encode};
use UIAwesome\Html\Interop\Block;

use function str_starts_with;

/**
 * Provides the base implementation for rendering HTML tags.
 *
 * @see https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 * @see https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 * @see https://developer.mozilla.org/en-US/docs/Glossary/Void_element
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#main_root
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#table_content
 */
abstract class BaseHtml
{
    /**
     * Returns the opening tag for a block element.
     *
     * @param BackedEnum $tag Tag enumeration instance.
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
    public static function begin(BackedEnum $tag, array $attributes = []): string
    {
        $renderAttributes = Attributes::render($attributes);

        if ($tag === Block::PRE || $tag === Block::TEXT_AREA) {
            return "<{$tag->value}{$renderAttributes}>";
        }

        return "<{$tag->value}{$renderAttributes}>\n";
    }

    /**
     * Returns a complete HTML element `string`.
     *
     * @param BackedEnum $tag Tag enumeration instance.
     * @param string $content Content to be rendered inside the tag.
     * @param array $attributes Associative array of HTML attributes.
     * @param bool $encode Whether to encode the content for HTML output.
     *
     * @return string Rendered HTML element string.
     *
     * The `pre` and `textarea` elements do not receive presentation newlines around nonempty content. A protective
     * newline is added only when their content starts with a newline, which the HTML parser otherwise ignores.
     *
     * {@see \UIAwesome\Html\Interop\Block} for valid block-level tags.
     * {@see \UIAwesome\Html\Interop\Inline} for valid inline-level tags.
     * {@see \UIAwesome\Html\Interop\Lists} for valid list-level tags.
     * {@see \UIAwesome\Html\Interop\Root} for valid root-level tags.
     * {@see \UIAwesome\Html\Interop\Table} for valid table-level tags.
     * For void tags, use {@see \UIAwesome\Html\Core\Html::void()}.
     *
     * @phpstan-param mixed[] $attributes
     */
    public static function element(
        BackedEnum $tag,
        string $content,
        array $attributes = [],
        bool $encode = false,
    ): string {
        if ($encode) {
            $content = Encode::content($content);
        }

        $renderAttributes = Attributes::render($attributes);

        if ($content === '') {
            return "<{$tag->value}{$renderAttributes}>\n</{$tag->value}>";
        }

        if ($tag === Block::PRE || $tag === Block::TEXT_AREA) {
            $leadingNewline = str_starts_with($content, "\n") ? "\n" : '';

            return "<{$tag->value}{$renderAttributes}>{$leadingNewline}{$content}</{$tag->value}>";
        }

        return "<{$tag->value}{$renderAttributes}>\n{$content}\n</{$tag->value}>";
    }

    /**
     * Returns the closing tag for a block element.
     *
     * @param BackedEnum $tag Tag enumeration instance.
     *
     * @return string Rendered closing tag string.
     *
     * No presentation newline is added before `pre` or `textarea` closing tags, so streamed content stays intact.
     *
     * {@see \UIAwesome\Html\Interop\Block} for valid block-level tags.
     * {@see \UIAwesome\Html\Interop\Lists} for valid list-level tags.
     * {@see \UIAwesome\Html\Interop\Root} for valid root-level tags.
     * {@see \UIAwesome\Html\Interop\Table} for valid table-level tags.
     */
    public static function end(BackedEnum $tag): string
    {
        if ($tag === Block::PRE || $tag === Block::TEXT_AREA) {
            return "</{$tag->value}>";
        }

        return "\n</{$tag->value}>";
    }

    /**
     * Returns an inline HTML element `string`.
     *
     * @param BackedEnum $tag Inline tag enumeration instance.
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
        BackedEnum $tag,
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
     * @param BackedEnum $tag Void tag enumeration instance.
     * @param array $attributes Associative array of HTML attributes.
     *
     * @return string Rendered void HTML element string.
     *
     * {@see \UIAwesome\Html\Interop\Voids} for valid void-level tags.
     *
     * @phpstan-param mixed[] $attributes
     */
    public static function void(BackedEnum $tag, array $attributes = []): string
    {
        $renderAttributes = Attributes::render($attributes);

        return "<{$tag->value}{$renderAttributes}>";
    }
}
