<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use InvalidArgumentException;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Helper\Validator;

/**
 * Trait for managing the global HTML `tabindex` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `tabindex` attribute on HTML elements, following the
 * HTML specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of element tab order,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `tabindex` global attribute.
 * - Immutable method for setting or overriding the `tabindex` attribute.
 * - Supports int, string, and `null` for flexible tab order assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/tabindex
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasTabindex
{
    /**
     * Sets the HTML `tabindex` attribute for the element.
     *
     * Creates a new instance with the specified tab order value, supporting both explicit and nullable assignment
     * according to the HTML specification for global attributes.
     *
     * @param int|string|null $value Tab order value to set for the element. Can be `null` to unset the attribute.
     *
     * @throws InvalidArgumentException if the value is not a valid integer or string representation of an
     * `value >= -1`.
     * @return static New instance with the updated `tabindex` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#attr-tabindex
     *
     * Usage example:
     * ```php
     * // sets the `tabindex` attribute to `3`
     * $element->tabIndex(3);
     * ```
     */
    public function tabIndex(int|string|null $value): static
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes['tabindex']);

            return $new;
        }

        if ($value !== -1 && $value !== '-1' && Validator::intLike($value) === false) {
            throw new InvalidArgumentException(
                Message::INVALID_ATTRIBUTE_VALUE->getMessage($value, 'tabindex', 'value >= -1'),
            );
        }

        $new->attributes['tabindex'] = $value;

        return $new;
    }
}
