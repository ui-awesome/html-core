<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

use Stringable;
use UIAwesome\Html\Attribute\Global\{
    CanBeHidden,
    HasAccesskey,
    HasAria,
    HasClass,
    HasData,
    HasDir,
    HasEvents,
    HasId,
    HasLang,
    HasRole,
    HasStyle,
    HasTitle,
    HasTranslate,
};
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Helper\Template;
use UIAwesome\Html\Interop\{BlockInterface, InlineInterface, VoidInterface};
use UIAwesome\Html\Mixin\{HasAttributes, HasContent, HasPrefixCollection, HasSuffixCollection, HasTemplate};

/**
 * Base class for constructing inline-level HTML elements.
 *
 * Provides the shared implementation for inline tags rendered through {@see Html}. Subclasses supply the tag via
 * {@see BaseInline::getTag()}, while attributes, content, and optional prefix/suffix rendering are managed via mixins.
 *
 * Intended for tag classes that need inline rendering with optional template-driven composition.
 *
 * Key features.
 * - Builds composed output via {@see BaseInline::buildElement()} and {@see Template::render()}.
 * - Mixes in global attribute traits and attribute/content storage.
 * - Renders inline tags via {@see Html::inline()} and can skip tag rendering when configured.
 * - Requires subclasses to provide a {@see InlineInterface} tag.
 * - Supports additional template token values for prefix/tag/suffix rendering.
 *
 * {@see InlineInterface} for contract details.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseInline extends BaseTag
{
    use CanBeHidden;
    use HasAccesskey;
    use HasAria;
    use HasAttributes;
    use HasClass;
    use HasContent;
    use HasData;
    use HasDir;
    use HasEvents;
    use HasId;
    use HasLang;
    use HasPrefixCollection;
    use HasRole;
    use HasStyle;
    use HasSuffixCollection;
    use HasTemplate;
    use HasTitle;
    use HasTranslate;

    /**
     * Returns the tag instance representing the inline element.
     *
     * Must be implemented by subclasses to specify the concrete inline tag.
     *
     * @return InlineInterface Tag instance for the inline element.
     *
     * Usage example:
     * ```php
     * public function getTag(): InlineInterface
     * {
     *    return Inline::SPAN;
     * }
     * ```
     */
    abstract protected function getTag(): InlineInterface;

    /**
     * Builds the inline element using the provided content and token values.
     *
     * Constructs the element by rendering the prefix, main tag, and suffix using the configured template and
     * attributes.
     *
     * @param string|Stringable $content Content to be rendered inside the tag.
     * @param array $tokenValues Additional token values for template rendering.
     *
     * @return string Rendered HTML for the inline element.
     *
     * @phpstan-param mixed[] $tokenValues
     *
     * @phpstan-return string
     */
    protected function buildElement(string|Stringable $content = '', array $tokenValues = []): string
    {
        $tokenTemplateValues = [
            '{prefix}' => $this->renderTag($this->prefixTag, $this->prefix, $this->prefixAttributes),
            '{tag}' => $this->renderTag($this->getTag(), (string) $content, $this->getAttributes()),
            '{suffix}' => $this->renderTag($this->suffixTag, $this->suffix, $this->suffixAttributes),
        ];

        $tokenTemplateValues += $tokenValues;
        $template = $this->template;

        if ($template === '') {
            $template = '{prefix}\n{tag}\n{suffix}';
        }

        return Template::render($template, $tokenTemplateValues);
    }

    /**
     * Renders a tag or returns the content if the tag is not specified.
     *
     * @param BlockInterface|false|InlineInterface|VoidInterface $tag Tag instance or `false` to skip rendering.
     * @param string $content Content to be rendered inside the tag.
     * @param array $attributes HTML attributes for the tag.
     *
     * @return string Rendered tag or content.
     *
     * @phpstan-param mixed[] $attributes
     *
     * @phpstan-return string
     */
    private function renderTag(
        BlockInterface|false|InlineInterface|VoidInterface $tag,
        string $content,
        array $attributes = [],
    ): string {
        if ($tag === false) {
            return $content;
        }

        return Html::element($tag, $content, $attributes);
    }
}
