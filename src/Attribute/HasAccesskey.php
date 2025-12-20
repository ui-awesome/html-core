<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

/**
 * Trait for managing the global HTML `accesskey` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `accesskey` attribute on HTML elements, following the
 * HTML specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of element access keys,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `accesskey` global attributes.
 * - Immutable method for setting or overriding the `accesskey` attribute.
 * - Supports string and `null` for flexible access key assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/accesskey
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasAccesskey
{
    /**
     * Sets the HTML `accesskey` attribute for the element.
     *
     * Creates a new instance with the specified access key, supporting both explicit and nullable assignment according
     * to the HTML specification for global attributes.
     *
     * @param string|null $value Access key to set for the element. Can be `null` to unset the attribute.
     *
     * @return static New instance with the updated `accesskey` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#the-accesskey-attribute
     *
     * Usage example:
     * ```php
     * // sets the `accesskey` attribute to 'k'
     * $element->accesskey('k');
     *
     * // unsets the `accesskey` attribute
     * $element->accesskey(null);
     * ```
     */
    public function accesskey(string|null $value): static
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes['accesskey']);
        } else {
            $new->attributes['accesskey'] = $value;
        }

        return $new;
    }
}
