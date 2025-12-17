<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use InvalidArgumentException;
use UIAwesome\Html\Core\Values\ContentEditable;
use UIAwesome\Html\Helper\Validator;
use UnitEnum;

use function is_bool;

/**
 * Trait for managing the global HTML `contenteditable` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `contenteditable` attribute on HTML elements, following
 * the HTML specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of content editability,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `contenteditable` global attribute.
 * - Immutable method for setting or overriding the `contenteditable` attribute.
 * - Supports bool, string, UnitEnum, and `null` for flexible editability assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/contenteditable
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasContentEditable
{
    /**
     * Sets the HTML `contenteditable` attribute for the element.
     *
     * Creates a new instance with the specified content editability value, supporting both explicit and nullable
     * assignment according to the HTML specification for global attributes.
     *
     * @param bool|string|UnitEnum|null $value Content editability value to set for the element. Can be `null` to unset
     * the attribute.
     *
     * @throws InvalidArgumentException if the provided value is not valid.
     *
     * @return static New instance with the updated `contenteditable` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#attr-contenteditable
     * {@see ContentEditable} for predefined enum values.
     *
     * Usage example:
     * ```php
     * // sets the `contenteditable` attribute to `false`
     * $element->contentEditable('false');
     *
     * // sets the `contenteditable` attribute to `true`
     * $element->contentEditable(ContentEditable::TRUE);
     * ```
     */
    public function contentEditable(bool|string|UnitEnum|null $value): static
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes['contenteditable']);

            return $new;
        }

        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        Validator::oneOf($value, ContentEditable::cases(), 'contenteditable');

        $new->attributes['contenteditable'] = $value;

        return $new;
    }
}
