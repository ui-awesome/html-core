<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use UnitEnum;

/**
 * Trait for managing the global HTML `style` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `style` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of inline CSS styles,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `style` global attributes.
 * - Immutable method for setting or overriding the `style` attribute.
 * - Supports string, UnitEnum, and `null` for flexible style assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/style
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasStyle
{
    /**
     * Sets the HTML `style` attribute for the element.
     *
     * Creates a new instance with the specified style value, supporting both explicit and nullable assignment according
     * to the HTML specification for global attributes.
     *
     * @param string|UnitEnum|null $value Style value to set for the element. Can be `null` to unset the attribute.
     *
     * @return static New instance with the updated `style` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-style-attribute
     *
     * Usage example:
     * ```php
     * // sets the `style` attribute to 'color: red;'
     * $element->style('color: red;');
     *
     * // sets the `style` attribute to 'color: red;' if `StyleEnum::RED_TEXT` is a `UnitEnum`
     * $element->style(StyleEnum::RED_TEXT);
     *
     * // unsets the `style` attribute
     * $element->style(null);
     * ```
     */
    public function style(string|UnitEnum|null $value): static
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes['style']);
        } else {
            $new->attributes['style'] = $value;
        }

        return $new;
    }
}
