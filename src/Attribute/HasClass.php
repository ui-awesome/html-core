<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use Stringable;
use UIAwesome\Html\Helper\CSSClass;
use UnitEnum;

/**
 * Trait for managing the global HTML `class` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `class` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of CSS classes, ensuring
 * correct attribute handling and value merging.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Immutable method for setting or overriding the `class` attribute.
 * - Integration with CSS class management utilities for safe and predictable value updates.
 * - Standards-compliant handling of the HTML `class` global attributes.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/class
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasClass
{
    /**
     * Sets the HTML `class` attribute for the element.
     *
     * Creates a new instance with the specified CSS class, optionally overriding any existing class.
     *
     * This method ensures standards-compliant handling of the `class` global attributes, supporting both additive and
     * override semantics as required by the HTML specification.
     *
     * @param string|Stringable|UnitEnum|null $value CSS class to set for the element. Can be `null` to unset the
     * attribute.
     * @param bool $override Whether to override the existing class (`true`) or merge (`false`).
     *
     * @return static New instance with the updated `class` attribute.
     *
     * @link https://html.spec.whatwg.org/#classes
     *
     * Usage example:
     * ```php
     * // sets the `class` attribute to 'my-class'
     * $element->class('my-class');
     *
     * // sets the `class` attribute to 'primary' if `Theme::PRIMARY` is a `UnitEnum`
     * $element->class(Theme::PRIMARY);
     *
     * // sets the `class` attribute to Stringable
     * $element->class(
     *     new class implements Stringable {
     *         public function __toString(): string
     *         {
     *            return 'stringable-class';
     *         }
     *     },
     * );
     *
     * // overrides the `class` attribute with 'another-class'
     * $element->class('another-class', true);
     *
     * // unsets the `class` attribute
     * $element->class(null);
     * ```
     */
    public function class(string|Stringable|UnitEnum|null $value, bool $override = false): static
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes['class']);
        } else {
            CSSClass::add($new->attributes, $value, $override);
        }

        return $new;
    }
}
