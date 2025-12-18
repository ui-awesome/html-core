<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Mixin;

use function array_merge;

/**
 * Trait for managing global HTML attributes in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting arbitrary HTML attributes on elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in components that require dynamic or programmatic manipulation of element attributes, ensuring
 * correct attribute handling, type safety, and value merging.
 *
 * Key features.
 * - Designed for use in tag rendering systems.
 * - Enforces standards-compliant handling of HTML global attributes.
 * - Immutable method for setting or overriding attributes.
 * - Supports merging of multiple attribute arrays for flexible assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Attributes
 * @link https://www.w3.org/TR/html52/dom.html#global-attributes
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasAttributes
{
    /**
     * HTML attributes array used by the implementing class.
     *
     * @phpstan-var mixed[] $attributes
     */
    protected array $attributes = [];

    /**
     * Sets a single HTML attribute for the element.
     *
     * Creates a new instance with the specified attribute, overriding any existing value for that attribute.
     *
     * @param string $name  Attribute name.
     * @param mixed  $value Attribute value.
     *
     * @return static New instance with the updated attribute.
     *
     * Usage example:
     * ```php
     * // sets a single attribute
     * $element->addAttribute('id', 'my-id');
     * ```
     */
    public function addAttribute(string $name, mixed $value): static
    {
        $new = clone $this;
        $new->attributes[$name] = $value;

        return $new;
    }

    /**
     * Sets one or more HTML attributes for the element.
     *
     * Creates a new instance with the specified attributes, merging them with any existing attributes according to
     * standards-compliant handling of HTML global attributes.
     *
     * @param array $values Associative array of attribute keys and values.
     *
     * @return static New instance with the updated attributes.
     *
     * @phpstan-param mixed[] $values
     *
     * Usage example:
     * ```php
     * // sets multiple attributes
     * $element->attributes(['id' => 'my-id', 'data-role' => 'button']);
     * ```
     */
    public function attributes(array $values): static
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $values);

        return $new;
    }

    /**
     * Returns the array of HTML attributes for the element.
     *
     * @return array Attributes array assigned to the element.
     *
     * @phpstan-return mixed[]
     *
     * Usage example:
     * ```php
     * $attrs = $element->getAttributes();
     * ```
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Removes a specific HTML attribute from the element.
     *
     * Creates a new instance without the specified attribute.
     *
     * @param string $name Attribute name to remove.
     *
     * @return static New instance without the specified attribute.
     *
     * Usage example:
     * ```php
     * // removes a single attribute
     * $element->removeAttribute('id');
     * ```
     */
    public function removeAttribute(string $name): static
    {
        $new = clone $this;
        unset($new->attributes[$name]);

        return $new;
    }
}
