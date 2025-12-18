<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use Closure;
use InvalidArgumentException;
use UIAwesome\Html\Core\Exception\Message;

use function gettype;
use function is_string;

/**
 * Trait for managing the global HTML `data-*` attributes in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting custom data attributes on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of `data-*` attributes,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `data-*` global attributes.
 * - Immutable method for setting or overriding `data-*` attributes.
 * - Supports string and Closure values for advanced dynamic data scenarios.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/data-*
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasData
{
    /**
     * Sets one or more HTML `data-*` attributes for the element.
     *
     * Creates a new instance with the specified custom data attributes, supporting both string and Closure values as
     * required by the HTML specification for global attributes. Enforces standards-compliant key and value types, and
     * throws an exception for invalid input.
     *
     * @param array $values Associative array of data attribute keys and values. Keys must be string; values must be
     * string or `Closure(): string`.
     *
     * @throws InvalidArgumentException if one or more arguments are invalid, of incorrect type or format.
     *
     * @return static New instance with the updated `data-*` attributes.
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#attr-data-*
     *
     * @phpstan-param mixed[] $values
     *
     * Usage example:
     * ```php
     * // sets `data-role` and `data-id` attributes
     * $element->dataAttributes(
     *     [
     *         'role' => 'admin',
     *         'id' => static fn(): string => uniqid(),
     *     ],
     * );
     * ```
     */
    public function dataAttributes(array $values): static
    {
        $new = clone $this;

        foreach ($values as $key => $value) {
            if ($key === '') {
                throw new InvalidArgumentException(
                    Message::DATA_ATTRIBUTE_KEY_NOT_EMPTY->getMessage(),
                );
            }

            if (is_string($key) === false) {
                throw new InvalidArgumentException(
                    Message::DATA_ATTRIBUTE_KEY_MUST_BE_STRING->getMessage(gettype($key)),
                );
            }

            if ($value instanceof Closure === false && is_string($value) === false) {
                throw new InvalidArgumentException(
                    Message::DATA_ATTRIBUTE_VALUE_MUST_BE_STRING_OR_CLOSURE->getMessage(gettype($value)),
                );
            }

            $new->attributes["data-$key"] = $value;
        }

        return $new;
    }
}
