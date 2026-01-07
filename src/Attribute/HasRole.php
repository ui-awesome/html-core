<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use InvalidArgumentException;
use UIAwesome\Html\Core\Values\{AttributeProperty, Role};
use UIAwesome\Html\Helper\Validator;
use UnitEnum;

/**
 * Trait for managing the global HTML `role` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `role` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of element roles, ensuring
 * correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `role` global attribute.
 * - Immutable method for setting or overriding the `role` attribute.
 * - Supports string, UnitEnum, and `null` for flexible role assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/role
 * @method static addAttribute(string|\UnitEnum $key, mixed $value) Adds an attribute and returns a new instance.
 * {@see \UIAwesome\Html\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasRole
{
    /**
     * Sets the HTML `role` attribute for the element.
     *
     * Creates a new instance with the specified role, supporting both explicit and nullable assignment according to the
     * HTML specification for global attributes.
     *
     * While the method accepts any UnitEnum for flexibility, runtime validation ensures only values matching
     * MDN-compliant {@see Role::cases()} are accepted.
     *
     * This allows users to create custom enums with compliant values while preventing browser errors from invalid
     * attribute values.
     *
     * @param string|UnitEnum|null $value Role to set for the element. Can be `null` to unset the
     * attribute.
     *
     * @throws InvalidArgumentException if the provided value is not valid.
     *
     * @return static New instance with the updated `role` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/infrastructure.html#attr-aria-role
     * {@see Role} for predefined enum values.
     *
     * Usage example:
     * ```php
     * // sets the `role` attribute to 'button'
     * $element->role('button');
     *
     * // sets the `role` attribute to 'alert'
     * $element->role(Role::ALERT);
     *
     * // unsets the `role` attribute
     * $element->role(null);
     * ```
     */
    public function role(string|UnitEnum|null $value): static
    {
        Validator::oneOf($value, Role::cases(), AttributeProperty::ROLE);

        return $this->addAttribute(AttributeProperty::ROLE, $value);
    }
}
