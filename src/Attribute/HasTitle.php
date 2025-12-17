<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use UnitEnum;

/**
 * Trait for managing the global HTML `title` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `title` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of tooltip text, ensuring
 * correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `title` global attributes.
 * - Immutable method for setting or overriding the `title` attribute.
 * - Supports `string`, `UnitEnum`, and `null` values for flexible title assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/title
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasTitle
{
    /**
     * Sets the HTML `title` attribute for the element.
     *
     * Creates a new instance with the specified title value, supporting both explicit and nullable assignment according
     * to the HTML specification for global attributes.
     *
     * @param string|UnitEnum|null $value Title value to set for the element. Can be `null` to unset the attribute.
     *
     * @return static New instance with the updated `title` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#attr-title
     *
     * Usage example:
     * ```php
     * // sets the `title` attribute to 'Tooltip text'
     * $element->title('Tooltip text');
     *
     * // sets the `title` attribute to 'Tooltip text' if `TitleEnum::TOOLTIP` is a `UnitEnum`.
     * $element->title(TitleEnum::TOOLTIP);
     *
     * // unsets the `title` attribute
     * $element->title(null);
     * ```
     */
    public function title(string|UnitEnum|null $value): static
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes['title']);
        } else {
            $new->attributes['title'] = $value;
        }

        return $new;
    }
}
