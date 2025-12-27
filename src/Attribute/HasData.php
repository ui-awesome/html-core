<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use Closure;
use InvalidArgumentException;
use Stringable;
use TypeError;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Helper\Attributes;
use UnitEnum;

use function gettype;

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
 * - Supports scalar, Closure and UnitEnum for advanced dynamic data scenarios.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/data-*
 * @phpstan-type Key string|UnitEnum
 * @phpstan-type Value scalar|Stringable|UnitEnum|null|Closure(): mixed
 * @method void setAttribute(Key $key, Value $value, string $prefix = '', bool $boolToString = false) Sets a single
 * attribute with prefix handling. Available via {@see \UIAwesome\Html\Core\Mixin\HasAttributes} trait composition.
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
     * @param bool|Closure|float|int|string|Stringable|UnitEnum|null $value Data attribute value. Can be `null` to unset
     * the attribute.
     *
     * @throws InvalidArgumentException if one or more arguments are invalid, of incorrect type or format.
     *
     * @return static New instance with the updated `data-*` attribute.
     *
     * @phpstan-param scalar|Stringable|UnitEnum|Closure(): mixed $value
     *
     * Usage example:
     * ```php
     * // sets `data-role` attribute
     * $element->addDataAttribute('role', 'admin');
     *
     * // sets `data-id` attribute with a Closure
     * $element->addDataAttribute('id', static fn(): string => uniqid());
     *
     * // sets `data-id` attribute with an enum key
     * $element->addDataAttribute(DataProperty::ID, '12345');
     *
     * // sets `data-size` attribute with an enum value
     * $element->addDataAttribute('size', ButtonSize::SMALL);
     *
     * // removes `data-role` attribute
     * $element->addDataAttribute('role', null);
     * ```
     */
    public function addDataAttribute(
        string|UnitEnum $key,
        bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
    ): static {
        $new = clone $this;

        $new->setAttribute($key, $value, 'data-');

        return $new;
    }

    /**
     * Sets one or more HTML `data-*` attributes for the element.
     *
     * Creates a new instance with the specified custom data attributes, supporting both string and Closure as required
     * by the HTML specification for global attributes. Enforces standards-compliant key and value types, and throws an
     * exception for invalid input.
     *
     * @param array $values Associative array of data attribute keys and values. Keys must be string; values must be
     * scalar, Closure, Stringable, UnitEnum or `null`.
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
     *
     * // sets `data-status` attribute with an enum value
     * $element->dataAttributes(
     *     [
     *         'status' => Status::ACTIVE,
     *     ],
     * );
     * ```
     */
    public function dataAttributes(array $values): static
    {
        $new = clone $this;

        /** @phpstan-var array<string, scalar|Stringable|UnitEnum|Closure(): mixed|null> $values */
        foreach ($values as $key => $value) {
            try {
                $new->setAttribute($key, $value, 'data-');
                // @phpstan-ignore catch.neverThrown
            } catch (TypeError) {
                throw new InvalidArgumentException(
                    Message::ATTRIBUTE_VALUE_MUST_BE_SCALAR_OR_CLOSURE->getMessage(gettype($value)),
                );
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
     *
     * // removes `data-id` attribute with an enum key
     * $element->removeDataAttribute(DataProperty::ID);
     * ```
     */
    public function removeDataAttribute(string|UnitEnum $key): static
    {
        $normalizedKey = Attributes::normalizeKey($key, 'data-');

        $new = clone $this;

        unset($new->attributes[$normalizedKey]);

        return $new;
    }
}
