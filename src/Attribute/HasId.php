<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

/**
 * Trait for managing the global HTML `id` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `id` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of element identifiers,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `id` global attributes.
 * - Immutable method for setting or overriding the `id` attribute.
 * - Supports string and `null` for flexible identifier assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/id
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasId
{
    /**
     * Sets the HTML `id` attribute for the element.
     *
     * Creates a new instance with the specified identifier value, supporting both explicit and nullable assignment
     * according to the HTML specification for global attributes.
     *
     * @param string|null $value Identifier value to set for the element. Can be `null` to unset the attribute.
     *
     * @return static New instance with the updated `id` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     *
     * Usage example:
     * ```php
     * // sets the `id` attribute to 'unique-element-id'
     * $element->id('unique-element-id');
     *
     * // unsets the `id` attribute
     * $element->id(null);
     * ```
     */
    public function id(string|null $value): static
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes['id']);
        } else {
            $new->attributes['id'] = $value;
        }

        return $new;
    }
}
