<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use InvalidArgumentException;
use UIAwesome\Html\Core\Values\Language;
use UIAwesome\Html\Helper\Validator;
use UnitEnum;

/**
 * Trait for managing the global HTML `lang` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `lang` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of language identifiers,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `lang` global attributes.
 * - Immutable method for setting or overriding the `lang` attribute.
 * - Supports string, UnitEnum, and `null` for flexible language assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/lang
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasLang
{
    /**
     * Sets the HTML `lang` attribute for the element.
     *
     * Creates a new instance with the specified language value, supporting both explicit and nullable assignment
     * according to the HTML specification for global attributes.
     *
     * @param string|UnitEnum|null $value Language value to set for the element. Can be `null` to unset the attribute.
     *
     * @throws InvalidArgumentException if the provided value is not valid.
     *
     * @return static New instance with the updated `lang` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#attr-lang
     * {@see Language} for predefined enum values.
     *
     * Usage example:
     * ```php
     * // sets the `lang` attribute to 'en-US'
     * $element->lang('en-US');
     *
     * // sets the `lang` attribute to 'en-US' if `Language::ENGLISH_US` is a `UnitEnum`
     * $element->lang(Language::ENGLISH_US);
     *
     * // unsets the `lang` attribute
     * $element->lang(null);
     * ```
     */
    public function lang(string|UnitEnum|null $value): static
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes['lang']);
        } else {
            Validator::oneOf($value, Language::cases(), 'lang');

            $new->attributes['lang'] = $value;
        }

        return $new;
    }
}
