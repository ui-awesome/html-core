<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

use BackedEnum;
use Stringable;
use UIAwesome\Html\Attribute\{CanBeDisabled, HasName, HasType};
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
use UIAwesome\Html\Attribute\Values\Attribute;
use UIAwesome\Html\Contracts\Form\FormControlInterface;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Element\Concern\HasElementBuilder;
use UIAwesome\Html\Mixin\{HasAttributes, HasPrefixCollection, HasSuffixCollection, HasTemplate};
use UnitEnum;

/**
 * Provides the base implementation for input elements.
 *
 * Builds input markup with attribute traits and template-driven prefix and suffix composition.
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input
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
    use HasElementBuilder;
    use HasEvents;
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
     * Sets the `form` attribute.
     *
     * Usage example:
     * ```php
     * $element->form('myForm');
     * $element->form($formId);
     * $element->form(null);
     * ```
     *
     * @param string|Stringable|UnitEnum|null $value Form ID, or `null` to remove the attribute.
     *
     * @return static New instance with the updated `form` attribute.
     */
    public function form(string|Stringable|UnitEnum|null $value): static
    {
        return $this->addAttribute(Attribute::FORM, $value);
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
}
