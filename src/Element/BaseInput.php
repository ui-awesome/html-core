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
use UIAwesome\Html\Attribute\{HasDisabled, HasForm, HasType};
use UIAwesome\Html\Attribute\Values\Attribute;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Helper\{Naming, Template};
use UIAwesome\Html\Interop\{BlockInterface, InlineInterface, VoidInterface};
use UIAwesome\Html\Mixin\{HasAttributes, HasPrefixCollection, HasSuffixCollection, HasTemplate};
use UnitEnum;

/**
 * Abstract base class for HTML input element components.
 *
 * Provides the foundation for creating various input type components (text, email, password, checkbox, radio, etc.).
 *
 * Implements common functionality for rendering input elements with prefix/suffix support and template-based
 * composition.
 *
 * This class serves as the base for all input element types and provides the structure for implementing HTML input
 * attributes through traits.
 *
 * Key features.
 * - Automatic ID generation based on class name.
 * - Immutable configuration through method chaining.
 * - Supports additional template token values for prefix/tag/suffix rendering.
 * - Template-based rendering with prefix, tag, and suffix placeholders.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseInput extends BaseTag
{
    use CanBeHidden;
    use HasAccesskey;
    use HasAria;
    use HasAttributes;
    use HasClass;
    use HasData;
    use HasDir;
    use HasDisabled;
    use HasEvents;
    use HasForm;
    use HasId;
    use HasLang;
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
     * Must be implemented by subclasses to specify the concrete void tag.
     *
     * @return VoidInterface Tag instance for the void element.
     *
     * Usage example:
     * ```php
     * public function getTag(): VoidInterface
     * {
     *     return Void::INPUT;
     * }
     * ```
     */
    abstract protected function getTag(): VoidInterface;

    /**
     * Sets the HTML `name` attribute for the input element.
     *
     * Note: The HTML `name` attribute for `<input>` elements is not limited to the set of standard metadata names used
     * by `<meta>`.
     *
     * @param string|Stringable|UnitEnum|null $value Name value to set for the input element. Can be `null` to unset.
     *
     * @return static New instance with the updated `name` attribute.
     */
    public function name(string|Stringable|UnitEnum|null $value): static
    {
        return $this->addAttribute(Attribute::NAME, $value);
    }

    /**
     * Builds the input element using the provided content and token values.
     *
     * Constructs the element by rendering the prefix, main tag, and suffix using the configured template and
     * attributes.
     *
     * @param string|Stringable $content Content to be rendered inside the tag.
     *
     * Note: The `<input>` element is a void element and does not render inner content.
     * Use attributes such as `value` to configure the input's value.
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
     * Returns the default configuration for the input element.
     *
     * Generates default values for the element based on the short class name.
     *
     * @return array Default configuration array with method calls as keys.
     *
     * @phpstan-return array<string, mixed>
     */
    protected function loadDefault(): array
    {
        $shortClassName = Naming::getShortNameClass(static::class, false, true);

        return [
            'id' => [Naming::generateId("$shortClassName-")],
            'template' => ['{prefix}\n{tag}\n{suffix}'],
        ];
    }

    /**
     * Renders a tag or returns the content if the tag is not specified.
     *
     * @param false|BlockInterface|InlineInterface|VoidInterface $tag Tag instance or `false` to skip rendering.
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
        false|BlockInterface|InlineInterface|VoidInterface $tag,
        string $content,
        array $attributes = [],
    ): string {
        if ($tag === false) {
            return $content;
        }

        return Html::element($tag, $content, $attributes);
    }
}
