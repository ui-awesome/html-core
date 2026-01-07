<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use UIAwesome\Html\Core\Values\AttributeProperty;

/**
 * Trait for managing the global HTML microdata attributes in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the microdata attributes (`itemid`, `itemprop`, `itemref`,
 * `itemscope`, `itemtype`) on HTML elements, following the HTML specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of microdata, ensuring
 * correct attribute handling, type safety and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML microdata global attributes.
 * - Immutable methods for setting or overriding microdata attributes.
 * - Supports bool, string and `null` for flexible microdata assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemid
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemprop
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemref
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemscope
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemtype
 * @method static addAttribute(string|\UnitEnum $key, mixed $value) Adds an attribute and returns a new instance.
 * {@see \UIAwesome\Html\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasMicroData
{
    /**
     * Sets the HTML `itemid` attribute for the element.
     *
     * Creates a new instance with the specified microdata item ID, supporting explicit and nullable assignment
     * according to the HTML specification for global attributes.
     *
     * @param string|null $value Microdata item ID to set for the element. Can be `null` to unset the attribute.
     *
     * @return static New instance with the updated `itemid` attribute.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemid
     *
     * Usage example:
     * ```php
     * // sets the `itemid` attribute to 'http://example.com/item'
     * $element = $element->itemId('http://example.com/item');
     *
     * // unsets the `itemid` attribute
     * $element = $element->itemId(null);
     * ```
     */
    public function itemId(string|null $value): static
    {
        return $this->addAttribute(AttributeProperty::ITEMID, $value);
    }

    /**
     * Sets the HTML `itemprop` attribute for the element.
     *
     * Creates a new instance with the specified microdata item property, supporting explicit and nullable assignment
     * according to the HTML specification for global attributes.
     *
     * @param string|null $value Microdata item property to set for the element. Can be `null` to unset the attribute.
     *
     * @return static New instance with the updated `itemprop` attribute.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemprop
     *
     * Usage example:
     * ```php
     * // sets the `itemprop` attribute to 'name'
     * $element = $element->itemProp('name');
     *
     * // unsets the `itemprop` attribute
     * $element = $element->itemProp(null);
     * ```
     */
    public function itemProp(string|null $value): static
    {
        return $this->addAttribute(AttributeProperty::ITEMPROP, $value);
    }

    /**
     * Sets the HTML `itemref` attribute for the element.
     *
     * Creates a new instance with the specified microdata item reference, supporting explicit and nullable
     * assignment according to the HTML specification for global attributes.
     *
     * @param string|null $value Microdata item reference to set for the element. Can be `null` to unset the attribute.
     *
     * @return static New instance with the updated `itemref` attribute.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemref
     *
     * Usage example:
     * ```php
     * // sets the `itemref` attribute to 'additional-info'
     * $element = $element->itemRef('additional-info');
     *
     * // unsets the `itemref` attribute
     * $element = $element->itemRef(null);
     * ```
     */
    public function itemRef(string|null $value): static
    {
        return $this->addAttribute(AttributeProperty::ITEMREF, $value);
    }

    /**
     * Sets the HTML `itemscope` attribute for the element.
     *
     * Creates a new instance with the specified microdata item scope, supporting explicit assignment according to the
     * HTML specification for global attributes.
     *
     * @param bool|null $value Microdata item scope to set for the element. Can be `null` to unset the attribute.
     *
     * @return static New instance with the updated `itemscope` attribute.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemscope
     *
     * Usage example:
     * ```php
     * // sets the `itemscope` attribute
     * $element = $element->itemScope(true);
     *
     * // unsets the `itemscope` attribute
     * $element = $element->itemScope(null);
     * ```
     */
    public function itemScope(bool|null $value): static
    {
        return $this->addAttribute(AttributeProperty::ITEMSCOPE, $value);
    }

    /**
     * Sets the HTML `itemtype` attribute for the element.
     *
     * Creates a new instance with the specified microdata item type, supporting explicit and nullable assignment
     * according to the HTML specification for global attributes.
     *
     * @param string|null $value Microdata item type to set for the element. Can be `null` to unset the attribute.
     *
     * @return static New instance with the updated `itemtype` attribute.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/itemtype
     *
     * Usage example:
     * ```php
     * // sets the `itemtype` attribute to 'http://schema.org/Person'
     * $element = $element->itemType('http://schema.org/Person');
     *
     * // unsets the `itemtype` attribute
     * $element = $element->itemType(null);
     * ```
     */
    public function itemType(string|null $value): static
    {
        return $this->addAttribute(AttributeProperty::ITEMTYPE, $value);
    }
}
