<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use Stringable;
use UIAwesome\Html\Core\Values\AttributeProperty;
use UnitEnum;

/**
 * Trait for managing the global HTML `style` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `style` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of inline CSS styles,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `style` global attributes.
 * - Immutable method for setting or overriding the `style` attribute.
 * - Supports string, UnitEnum, and `null` for flexible style assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/style
 * @method static addAttribute(string|\UnitEnum $key, mixed $value) Adds an attribute and returns a new instance.
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasStyle
{
    /**
     * Sets the HTML `style` attribute for the element.
     *
     * Creates a new instance with the specified style, supporting array, string, Stringable, UnitEnum, and `null`
     * assignment according to the HTML specification for global attributes.
     *
     * @param array|string|Stringable|UnitEnum|null $value Style to set for the element. Can be `null` to unset the
     * attribute.
     *
     * Expected array structure and processing.
     * - When an `array` is provided it MUST be an associative array of CSS property => value pairs, for example,
     *   `['color' => 'red', 'font-size' => '16px']`.
     * - Values SHOULD be strings or objects implementing `\Stringable`/`UnitEnum` that yield a valid CSS value.
     * - Array values are converted to single CSS string during rendering (for example, `color: red; font-size: 16px;`).
     * - No automatic deep validation is performed here; validation/escaping and the actual array to string conversion
     *   happen in the rendering/attribute handling layer (see `src/Html.php` or the class that serializes attributes
     *   for output).
     *
     * @return static New instance with the updated `style` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-style-attribute
     *
     * @phpstan-param mixed[]|string|Stringable|UnitEnum|null $value
     *
     * Usage example:
     * ```php
     * // sets the `style` attribute to 'color: red;'
     * $element->style('color: red;');
     *
     * // sets the `style` attribute to an array of styles
     * $element->style(
     *     [
     *         'color' => 'red',
     *         'font-size' => '16px',
     *     ]
     * );
     *
     * // sets the `style` attribute to 'color: red;' if `StyleEnum::RED_TEXT` is a `UnitEnum`
     * $element->style(StyleEnum::RED_TEXT);
     *
     * // set the `style` attribute with a Stringable
     * $element->style(
     *     new class implements Stringable {
     *         public function __toString(): string {
     *             return 'color: blue;';
     *         }
     *     }
     * );
     *
     * // unsets the `style` attribute
     * $element->style(null);
     * ```
     */
    public function style(array|string|Stringable|UnitEnum|null $value): static
    {
        return $this->addAttribute(AttributeProperty::STYLE, $value);
    }
}
