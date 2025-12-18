<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use Closure;
use InvalidArgumentException;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Helper\Enum;
use UnitEnum;

use function gettype;
use function is_scalar;
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
 * - Supports scalar, Closure and UnitEnum values for advanced dynamic data scenarios.
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
     * Sets a single HTML `data-*` attribute for the element.
     *
     * Creates a new instance with the specified custom data attribute, supporting scalar, Closure and UnitEnum values
     * as required by the HTML specification for global attributes.
     *
     * @param string|UnitEnum $key Data attribute key (without the `data-` prefix).
     * @param bool|float|int|string|Closure|UnitEnum|null $value Data attribute value. Can be `null` to unset the
     * attribute.
     *
     * @throws InvalidArgumentException if one or more arguments are invalid, of incorrect type or format.
     *
     * @return static New instance with the updated `data-*` attribute.
     *
     * @phpstan-param scalar|Closure(): mixed|UnitEnum $value
     *
     * Usage example:
     * ```php
     * // sets `data-role` attribute
     * $element->addDataAttribute('role', 'admin');
     *
     * // sets `data-id` attribute with a Closure
     * $element->addDataAttribute('id', static fn(): string => uniqid());
     *
     * // removes `data-role` attribute
     * $element->addDataAttribute('role', null);
     * ```
     */
    public function addDataAttribute(string|UnitEnum $key, bool|float|int|string|Closure|UnitEnum|null $value): static
    {
        $normalizedKey = Enum::normalizeValue($key);

        if ($normalizedKey === '') {
            throw new InvalidArgumentException(
                Message::DATA_ATTRIBUTE_KEY_NOT_EMPTY->getMessage(),
            );
        }

        if (is_string($normalizedKey) === false) {
            throw new InvalidArgumentException(
                Message::DATA_ATTRIBUTE_KEY_MUST_BE_STRING->getMessage(gettype($normalizedKey)),
            );
        }

        if ($value === null) {
            return $this->removeDataAttribute($normalizedKey);
        }

        $new = clone $this;

        $new->attributes["data-$normalizedKey"] = match ($value instanceof Closure) {
            true => $value,
            false => Enum::normalizeValue($value),
        };

        return $new;
    }

    /**
     * Sets one or more HTML `data-*` attributes for the element.
     *
     * Creates a new instance with the specified custom data attributes, supporting both string and Closure values as
     * required by the HTML specification for global attributes. Enforces standards-compliant key and value types, and
     * throws an exception for invalid input.
     *
     * @param array $values Associative array of data attribute keys and values. Keys must be string; values must be
     * scalar, Closure or UnitEnum.
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

            if ($value instanceof UnitEnum) {
                $value = Enum::normalizeValue($value);
            }

            if ($value instanceof Closure === false && is_scalar($value) === false && $value !== null) {
                throw new InvalidArgumentException(
                    Message::DATA_ATTRIBUTE_VALUE_MUST_BE_SCALAR_OR_CLOSURE->getMessage(gettype($value)),
                );
            }

            if ($value === null) {
                unset($new->attributes["data-$key"]);
            } else {
                $new->attributes["data-$key"] = $value;
            }
        }

        return $new;
    }

    /**
     * Removes a single HTML `data-*` attribute from the element.
     *
     * Creates a new instance with the specified custom data attribute removed.
     *
     * @param string|UnitEnum $key Data attribute key (without the `data-` prefix).
     *
     * @return static New instance with the specified `data-*` attribute removed.
     *
     * Usage example:
     * ```php
     * // removes `data-role` attribute
     * $element->removeDataAttribute('role');
     * ```
     */
    public function removeDataAttribute(string|UnitEnum $key): static
    {
        $normalizedKey = Enum::normalizeValue($key);

        $new = clone $this;

        unset($new->attributes["data-$normalizedKey"]);

        return $new;
    }
}
