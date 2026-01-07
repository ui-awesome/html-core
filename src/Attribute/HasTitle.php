<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use Stringable;
use UIAwesome\Html\Core\Values\AttributeProperty;
use UnitEnum;

/**
 * Trait for managing the global HTML `title` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `title` attribute on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of tooltip text, ensuring
 * correct attribute handling and type safety.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `title` global attributes.
 * - Immutable method for setting or overriding the `title` attribute.
 * - Supports string, Stringable, UnitEnum, and `null` for flexible title assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/title
 * @method static addAttribute(string|\UnitEnum $key, mixed $value) Adds an attribute and returns a new instance.
 * {@see \UIAwesome\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasTitle
{
    /**
     * Sets the HTML `title` attribute for the element.
     *
     * Creates a new instance with the specified title, supporting both explicit and nullable assignment according to
     * the HTML specification for global attributes.
     *
     * @param string|Stringable|UnitEnum|null $value Title value to set for the element. Can be `null` to unset the
     * attribute.
     *
     * @return static New instance with the updated `title` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#attr-title
     *
     * Usage example:
     * ```php
     * // sets the `title` attribute to 'Tooltip text'
     * $element->title('Tooltip text');
     *
     * // sets the `title` attribute to 'Tooltip text' if `TitleEnum::TOOLTIP` is a `UnitEnum`.
     * $element->title(TitleEnum::TOOLTIP);
     *
     * // sets the `title` attribute with a Stringable
     * $element->title(
     *     new class implements Stringable {
     *         public function __toString(): string {
     *             return 'Tooltip text from Stringable';
     *         }
     *     }
     * );
     *
     * // unsets the `title` attribute
     * $element->title(null);
     * ```
     */
    public function title(string|Stringable|UnitEnum|null $value): static
    {
        return $this->addAttribute(AttributeProperty::TITLE, $value);
    }
}
