<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use InvalidArgumentException;
use UIAwesome\Html\Core\Values\{AttributeProperty, Direction};
use UIAwesome\Html\Helper\Validator;
use UnitEnum;

/**
 * Trait for managing the global HTML `dir` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `dir` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of text directionality,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `dir` global attribute.
 * - Immutable method for setting or overriding the `dir` attribute.
 * - Supports string, UnitEnum, and `null` for flexible direction assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/dir
 * @method static addAttribute(string|\UnitEnum $key, mixed $value) Adds an attribute and returns a new instance.
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasDir
{
    /**
     * Sets the HTML `dir` attribute for the element.
     *
     * Creates a new instance with the specified directionality, supporting both explicit and nullable assignment
     * according to the HTML specification for global attributes.
     *
     * While the method accepts any UnitEnum for flexibility, runtime validation ensures only values matching
     * MDN-compliant {@see Direction::cases()} (`auto`, `ltr`, `rtl`) are accepted.
     *
     * This allows users to create custom enums with compliant values while preventing browser errors from invalid
     * attribute values.
     *
     * @param string|UnitEnum|null $value Directionality to set for the element. Can be `null` to unset the
     * attribute.
     *
     * @throws InvalidArgumentException if the provided value is not valid.
     *
     * @return static New instance with the updated `dir` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-dir-attribute
     * {@see Direction} for predefined enum values.
     *
     * Usage example:
     * ```php
     * // sets the `dir` attribute to 'ltr'
     * $element->dir('ltr');
     *
     * // sets the `dir` attribute to 'rtl'
     * $element->dir(Direction::RTL);
     * ```
     */
    public function dir(string|UnitEnum|null $value): static
    {
        Validator::oneOf($value, Direction::cases(), AttributeProperty::DIR);

        return $this->addAttribute(AttributeProperty::DIR, $value);
    }
}
