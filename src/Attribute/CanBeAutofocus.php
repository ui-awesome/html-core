<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

/**
 * Trait for managing the global HTML `autofocus` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `autofocus` attribute on HTML elements, following the
 * HTML specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of element focus behavior,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `autofocus` global attribute.
 * - Immutable method for setting or overriding the `autofocus` attribute.
 * - Supports bool values for explicit focus control.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/autofocus
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait CanBeAutofocus
{
    /**
     * Sets the HTML `autofocus` attribute for the element.
     *
     * Creates a new instance with the specified focus value, supporting explicit assignment according to the HTML
     * specification for global attributes.
     *
     * @param bool $value Focus value to set for the element.
     *
     * @return static New instance with the updated `autofocus` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/semantics.html#attr-autofocus
     *
     * Usage example:
     * ```php
     * // sets the `autofocus` attribute to `false`
     * $element->autofocus(false);
     *
     * // sets the `autofocus` attribute to `true`
     * $element->autofocus(true);
     * ```
     */
    public function autofocus(bool $value): static
    {
        $new = clone $this;
        $new->attributes['autofocus'] = $value;

        return $new;
    }
}
