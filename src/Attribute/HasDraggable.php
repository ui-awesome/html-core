<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use InvalidArgumentException;
use UIAwesome\Html\Core\Values\{AttributeProperty, Draggable};
use UIAwesome\Html\Helper\Validator;
use UnitEnum;

use function is_bool;

/**
 * Trait for managing the global HTML `draggable` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `draggable` attribute on HTML elements, following the
 * HTML specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of element drag behavior,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `draggable` global attribute.
 * - Immutable method for setting or overriding the `draggable` attribute.
 * - Supports bool, string, Draggable, and `null` for flexible drag assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/draggable
 * @method static addAttribute(string|\UnitEnum $key, mixed $value) Adds an attribute and returns a new instance.
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasDraggable
{
    /**
     * Sets the HTML `draggable` attribute for the element.
     *
     * Creates a new instance with the specified draggable, supporting both explicit and nullable assignment according
     * to the HTML specification for global attributes.
     *
     * While the method accepts any UnitEnum for flexibility, runtime validation ensures only values matching
     * MDN-compliant {@see Draggable::cases()} (`false`, `true`) are accepted.
     *
     * This allows users to create custom enums with compliant values while preventing browser errors from invalid
     * attribute values.
     *
     * @param bool|string|UnitEnum|null $value Draggable to set for the element. Can be `null` to unset
     * the attribute.
     *
     * @throws InvalidArgumentException if the provided value is not valid.
     *
     * @return static New instance with the updated `draggable` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#attr-draggable
     * {@see Draggable} for predefined enum values.
     *
     * Usage example:
     * ```php
     * // sets the `draggable` attribute to `false`
     * $element->draggable(false);
     *
     * // sets the `draggable` attribute to `true`
     * $element->draggable(Draggable::TRUE);
     * ```
     */
    public function draggable(bool|string|UnitEnum|null $value): static
    {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        Validator::oneOf($value, Draggable::cases(), AttributeProperty::DRAGGABLE);

        return $this->addAttribute(AttributeProperty::DRAGGABLE, $value);
    }
}
