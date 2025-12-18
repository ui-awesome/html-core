<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

/**
 * Trait for managing the global HTML `hidden` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `hidden` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of element visibility,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `hidden` global attribute.
 * - Immutable method for setting or overriding the `hidden` attribute.
 * - Supports bool values for explicit visibility control.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/hidden
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait CanBeHidden
{
    /**
     * Sets the HTML `hidden` attribute for the element.
     *
     * Creates a new instance with the specified visibility value, supporting explicit assignment according to the HTML
     * specification for global attributes.
     *
     * @param bool $value Visibility value to set for the element.
     *
     * @return static New instance with the updated `hidden` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/semantics.html#the-hidden-attribute
     *
     * Usage example:
     * ```php
     * // sets the `hidden` attribute to `false`
     * $element->hidden(false);
     *
     * // sets the `hidden` attribute to `true`
     * $element->hidden(true);
     * ```
     */
    public function hidden(bool $value): static
    {
        $new = clone $this;
        $new->attributes['hidden'] = $value;

        return $new;
    }
}
