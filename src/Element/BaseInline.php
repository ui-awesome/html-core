<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

use Stringable;
use UIAwesome\Html\Core\Attribute\{
    CanBeHidden,
    HasAccesskey,
    HasClass,
    HasData,
    HasDir,
    HasId,
    HasLang,
    HasRole,
    HasStyle,
    HasTitle,
    HasTranslate,
};
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Mixin\{HasAttributes, HasContent, HasPrefixCollection, HasSuffixCollection, HasTemplate};
use UIAwesome\Html\Core\Tag\Inline;
use UIAwesome\Html\Helper\Template;

/**
 * Base class for constructing HTML inline-level elements according to the HTML specification.
 *
 * Provides a standards-compliant, extensible foundation for inline tag rendering, supporting global HTML attributes,
 * content management, and attribute immutability.
 *
 * Intended for use in components and tags that require dynamic or programmatic manipulation of inline-level HTML
 * elements, supporting advanced rendering scenarios and consistent API design.
 *
 * Key features.
 * - Enforces standards-compliant handling of inline tags as defined by the HTML specification.
 * - Immutable API for attribute and content assignment.
 * - Implements the core logic for inline-level tag construction.
 * - Integrates global HTML attribute management via traits.
 * - Supports extensibility for custom inline element implementations.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 * {@see Inline} for valid inline-level tags.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseInline extends BaseTag
{
    use CanBeHidden;
    use HasAccesskey;
    use HasAttributes;
    use HasClass;
    use HasContent;
    use HasData;
    use HasDir;
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
     * @return Inline Tag instance for the inline element.
     */
    abstract protected function getTag(): Inline;

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
            '{tag}' => $this->renderTag($this->getTag(), (string) $content, $this->attributes),
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
     * Renders an inline tag or returns the content if the tag is not specified.
     *
     * @param bool|Inline $inlineTag Tag instance or `false` to skip rendering.
     * @param string $content Content to be rendered inside the tag.
     * @param array $attributes HTML attributes for the tag.
     *
     * @return string Rendered tag or content.
     *
     * @phpstan-param mixed[] $attributes
     *
     * @phpstan-return string
     */
    private function renderTag(bool|Inline $inlineTag, string $content, array $attributes = []): string
    {
        if ($inlineTag instanceof Inline) {
            return Html::inline($inlineTag, $content, $attributes);
        }

        return $content;
    }
}
