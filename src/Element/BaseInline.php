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
 * Provides the base implementation for inline HTML elements.
 *
 * Subclasses return an {@see InlineInterface} tag and can compose prefix, tag, and suffix output via templates.
 *
 * Usage example:
 * ```php
 * <?= \App\Html\SomeInline::tag()->content('Label')->render() ?>
 * ```
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
     * @return InlineInterface Tag instance for the inline element.
     *
     * Usage example:
     * ```php
     * public function getTag(): InlineInterface
     * {
     *     return \UIAwesome\Html\Interop\Inline::SPAN;
     * }
     * ```
     */
    abstract protected function getTag(): InlineInterface;

    /**
     * Builds inline output from content and template tokens.
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
            '{prefix}' => $this->renderTag($this->getPrefixTag(), $this->getPrefix(), $this->getPrefixAttributes()),
            '{tag}' => $this->renderTag($this->getTag(), (string) $content, $this->getAttributes()),
            '{suffix}' => $this->renderTag($this->getSuffixTag(), $this->getSuffix(), $this->getSuffixAttributes()),
        ];

        $template = $this->getTemplate();

        if ($template === '') {
            $template = "{prefix}\n{tag}\n{suffix}";
        }

        return Template::render($template, [...$tokenTemplateValues, ...$tokenValues]);
    }

    /**
     * Renders a tag, or returns content when the tag is `false`.
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
