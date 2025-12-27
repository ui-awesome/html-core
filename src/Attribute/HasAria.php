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
 * Trait for managing the global HTML `aria-*` attributes in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting custom aria attributes on HTML elements, following the HTML
 * specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of `aria-*` attributes,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `aria-*` global attributes.
 * - Immutable method for setting or overriding `aria-*` attributes.
 * - Supports scalar, Closure and UnitEnum for advanced dynamic aria scenarios.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes
 * @phpstan-type Key string|UnitEnum
 * @phpstan-type Value scalar|Stringable|UnitEnum|null|Closure(): mixed
 * @method void setAttribute(Key $key, Value $value, string $prefix = '', bool $boolToString = false) Sets a single
 * attribute with prefix handling. Available via {@see \UIAwesome\Html\Core\Mixin\HasAttributes} trait composition.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasAria
{
    /**
     * Sets a single HTML `aria-*` attribute for the element.
     *
     * Creates a new instance with the specified custom aria attribute, supporting scalar, Closure and UnitEnum values
     * as required by the ARIA specification for global attributes.
     *
     * @param string|UnitEnum $key Aria attribute key (without the `aria-` prefix).
     * @param bool|Closure|float|int|string|Stringable|UnitEnum|null $value Aria attribute value. Can be `null` to unset
     * the attribute.
     *
     * @throws InvalidArgumentException if one or more arguments are invalid, of incorrect type or format.
     *
     * @return static New instance with the updated `aria-*` attribute.
     *
     * @phpstan-param scalar|Stringable|UnitEnum|Closure(): mixed $value
     *
     * Usage example:
     * ```php
     * // sets `aria-pressed` attribute (boolean)
     * $element->addAriaAttribute('pressed', true);
     *
     * // sets `aria-label` attribute (string)
     * $element->addAriaAttribute('label', 'Close');
     *
     * // sets `aria-controls` attribute with a Closure that returns an IDREF
     * $element->addAriaAttribute('controls', static fn(): string => 'modal-1');
     *
     * // sets `aria-autocomplete` attribute with an enum value
     * $element->addAriaAttribute(Aria::AUTOCOMPLETE, 'list');
     *
     * // sets `aria-live` attribute with an enum key
     * $element->addAriaAttribute(Aria::LIVE, 'polite');
     *
     * // sets `aria-describedby` attribute with an enum value
     * $element->addAriaAttribute(Aria::DESCRIBEDBY, 'description');
     *
     * // removes `aria-pressed` attribute
     * $element->addAriaAttribute('pressed', null);
     * ```
     */
    public function addAriaAttribute(
        string|UnitEnum $key,
        bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
    ): static {
        $new = clone $this;

        $new->setAttribute($key, $value, 'aria-', true);

        return $new;
    }

    /**
     * Sets one or more HTML `aria-*` attributes for the element.
     *
     * Creates a new instance with the specified custom aria attributes, supporting both string and Closure as required
     * by the ARIA and HTML specifications. Enforces standards-compliant key and value types, and throws an exception
     * for invalid input.
     *
     * @param array $values Associative array of aria attribute keys and values. Keys must be string; values must be
     * scalar, Closure, Stringable, UnitEnum or `null`.
     *
     * @throws InvalidArgumentException if one or more arguments are invalid, of incorrect type or format.
     *
     * @return static New instance with the updated `aria-*` attributes.
     *
     * @link https://html.spec.whatwg.org/#attr-aria-*
     *
     * @phpstan-param mixed[] $values
     *
     * Usage example:
     * ```php
     * // sets multiple aria attributes at once
     * $element->ariaAttributes(
     *     [
     *         'controls' => static fn(): string => 'modal-1',
     *         'hidden' => false,
     *         'label' => 'Close',
     *     ],
     * );
     *
     * // sets `aria-live` attribute with an enum value
     * $element->ariaAttributes(
     *     [
     *         'live' => Live::POLITE,
     *     ],
     * );
     * ```
     */
    public function ariaAttributes(array $values): static
    {
        $new = clone $this;

        /** @phpstan-var array<string, scalar|Stringable|UnitEnum|Closure(): mixed|null> $values */
        foreach ($values as $key => $value) {
            try {
                $new->setAttribute($key, $value, 'aria-', true);
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
     * Removes a single HTML `aria-*` attribute from the element.
     *
     * Creates a new instance with the specified custom aria attribute removed.
     *
     * @param string|UnitEnum $key Aria attribute key (without the `aria-` prefix).
     *
     * @return static New instance with the specified `aria-*` attribute removed.
     *
     * Usage example:
     * ```php
     * // removes `aria-pressed` attribute
     * $element->removeAriaAttribute('pressed');
     *
     * // removes `aria-autocomplete` attribute with an enum key
     * $element->removeAriaAttribute(Aria::AUTOCOMPLETE);
     * ```
     */
    public function removeAriaAttribute(string|UnitEnum $key): static
    {
        $normalizedKey = Attributes::normalizeKey($key, 'aria-');

        $new = clone $this;

        unset($new->attributes[$normalizedKey]);

        return $new;
    }
}
