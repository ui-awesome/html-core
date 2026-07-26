<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element\Concern;

use BackedEnum;
use Stringable;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Helper\Template;
use UIAwesome\Html\Interop\{Inline, MetadataVoid, Voids};

/**
 * Provides template-driven composition of the prefix, tag, and suffix segments of an element.
 *
 * Each segment is rendered with the renderer matching its tag kind, and the `{prefix}`, `{tag}`, and `{suffix}` tokens
 * are then replaced in the configured template.
 */
trait HasElementBuilder
{
    /**
     * Builds element output from content and template tokens.
     *
     * Usage example:
     * ```php
     * protected function run(): string
     * {
     *     return $this->buildElement($this->getContent());
     * }
     * ```
     *
     * @param string|Stringable $content Content to be rendered inside the tag. Void tags, such as `<input>`, render no
     * inner content; use attributes such as `value` instead.
     * @param array $tokenValues Additional token values for template rendering.
     *
     * @return string Rendered HTML for the element.
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
     * @param BackedEnum|false $tag Tag instance or `false` to skip rendering.
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
        BackedEnum|false $tag,
        string $content,
        array $attributes = [],
    ): string {
        if ($tag === false) {
            return $content;
        }

        if ($tag instanceof Voids || $tag instanceof MetadataVoid) {
            return Html::void($tag, $attributes);
        }

        if ($tag instanceof Inline) {
            return Html::inline($tag, $content, $attributes);
        }

        return Html::element($tag, $content, $attributes);
    }
}
