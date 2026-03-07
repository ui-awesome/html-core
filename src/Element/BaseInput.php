<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

use BackedEnum;
use Stringable;
use UIAwesome\Html\Attribute\{CanBeDisabled, HasName, HasType};
use UIAwesome\Html\Attribute\Form\HasForm;
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
use UIAwesome\Html\Contracts\Form\FormControlInterface;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Helper\Template;
use UIAwesome\Html\Interop\{Inline, MetadataVoid, Voids};
use UIAwesome\Html\Mixin\{HasAttributes, HasPrefixCollection, HasSuffixCollection, HasTemplate};

/**
 * Provides the base implementation for input elements.
 *
 * Builds input markup with attribute traits and template-driven prefix and suffix composition.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseInput extends BaseTag implements FormControlInterface
{
    use CanBeDisabled;
    use CanBeHidden;
    use HasAccesskey;
    use HasAria;
    use HasAttributes;
    use HasClass;
    use HasData;
    use HasDir;
    use HasEvents;
    use HasForm;
    use HasId;
    use HasLang;
    use HasName;
    use HasPrefixCollection;
    use HasRole;
    use HasStyle;
    use HasSuffixCollection;
    use HasTemplate;
    use HasTitle;
    use HasTranslate;
    use HasType;

    /**
     * Returns the tag instance representing the void element.
     *
     * @return BackedEnum Tag instance for the void element.
     *
     * Usage example:
     * ```php
     * public function getTag(): BackedEnum
     * {
     *     return \UIAwesome\Html\Interop\Voids::INPUT;
     * }
     * ```
     */
    abstract protected function getTag(): BackedEnum;

    /**
     * Builds input output from content and template tokens.
     *
     * @param string|Stringable $content Content to be rendered inside the tag.
     * Note: The `<input>` element is a void element and does not render inner content. Use attributes such as `value`
     * to configure the input's value.
     * @param array $tokenValues Additional token values for template rendering.
     *
     * @return string Rendered HTML for the input element.
     *
     * @phpstan-param mixed[] $tokenValues
     *
     * @phpstan-return string
     */
    protected function buildElement(string|Stringable $content = '', array $tokenValues = []): string
    {
        $attributes = $this->getAttributes();

        $tokenTemplateValues = [
            '{prefix}' => $this->renderTag($this->getPrefixTag(), $this->getPrefix(), $this->getPrefixAttributes()),
            '{tag}' => $this->renderTag($this->getTag(), (string) $content, $attributes),
            '{suffix}' => $this->renderTag($this->getSuffixTag(), $this->getSuffix(), $this->getSuffixAttributes()),
        ];

        $template = $this->getTemplate();

        if ($template === '') {
            $template = "{prefix}\n{tag}\n{suffix}";
        }

        return Template::render($template, [...$tokenTemplateValues, ...$tokenValues]);
    }

    /**
     * Returns class-level default configuration for input elements.
     *
     * @return array Default configuration array with method calls as keys.
     *
     * @phpstan-return array<string, mixed>
     */
    protected function loadDefault(): array
    {
        return [
            'template' => ["{prefix}\n{tag}\n{suffix}"],
        ];
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
