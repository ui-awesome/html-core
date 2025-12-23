<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use Closure;
use InvalidArgumentException;
use Stringable;
use TypeError;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Helper\Enum;
use UnitEnum;

use function gettype;
use function is_string;
use function str_starts_with;

/**
 * Trait for managing the global HTML event handler attributes (the `on*` attributes).
 *
 * Provides a standards-compliant, immutable API for setting event handler attributes on HTML elements, following the
 * HTML specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of event handler
 * attributes, ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `on*` global event handler attributes.
 * - Immutable method for setting or overriding the event handler attributes.
 * - Supports scalar, Closure and UnitEnum for advanced dynamic event scenarios.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes#event_handler_attributes
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasEvents
{
    /**
     * Sets a single global `on*` event attribute for the element.
     *
     * Creates a new instance with the specified event handler attribute, supporting both string and Closure values as
     * required by the HTML specification. The event key can be provided as a raw string (for example, `'onclick'` or
     * `'click'`) or as a `UnitEnum` (for example, `Event::CLICK`).
     *
     * @param string|UnitEnum $event Event attribute key (with or without the leading `on` prefix) or enum case.
     * @param Closure|string|Stringable|UnitEnum|null $handler JavaScript handler code. Can be `null` to unset the
     * attribute.
     *
     * @throws InvalidArgumentException if one or more arguments are invalid, of incorrect type or format.
     *
     * @return static New instance with the updated event attribute.
     *
     * @phpstan-param string|Stringable|Closure(): mixed|null $handler
     *
     * Usage example:
     * ```php
     * // sets `onclick` attribute using enum
     * $element->addEvent(Event::CLICK, "alert('hello')");
     *
     * // sets `onclick` using string key without `on` prefix
     * $element->addEvent('click', "alert('x')");
     *
     * // sets `onsubmit` attribute with a Closure
     * $element->addEvent('submit', static fn(): string => 'return validate()');
     *
     * // removes `onclick` attribute
     * $element->addEvent(Event::CLICK, null);
     * ```
     */
    public function addEvent(string|UnitEnum $event, string|Closure|Stringable|UnitEnum|null $handler): static
    {
        $new = clone $this;
        $new->addEventInternal($event, $handler);

        return $new;
    }

    /**
     * Sets one or more global `on*` event attributes at once.
     *
     * Creates a new instance with the specified event attributes, supporting both string and Closure. Enforces
     * standards-compliant key and value types, and throws an exception for invalid input.
     *
     * @param array $values Associative array where keys are event names or enum cases and values are handler strings,
     * Closure, Stringable or `null`.
     *
     * @throws InvalidArgumentException if one or more arguments are invalid, of incorrect type or format.
     *
     * @return static New instance with the updated event attributes.
     *
     * @phpstan-param mixed[] $values
     *
     * Usage example:
     * ```php
     * // sets multiple event attributes at once
     * $element->events(
     *     [
     *         'click' => "alert('Clicked!')",
     *         'mouseover' => static fn(): string => "console.log('Hover')",
     *     ],
     * );
     * ```
     */
    public function events(array $values): static
    {
        $new = clone $this;

        /** @phpstan-var array<string|UnitEnum, string|Closure|Stringable|null> $values */
        foreach ($values as $key => $value) {
            try {
                $new->addEventInternal($key, $value);
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
     * Removes a single global `on*` event attribute from the element.
     *
     * Creates a new instance with the specified event attribute removed.
     *
     * @param string|UnitEnum $event Event name or enum case to remove.
     *
     * @throws InvalidArgumentException if the event key is invalid.
     *
     * @return static New instance with the specified event attribute removed.
     *
     * Usage example:
     * ```php
     * // removes `onclick` attribute
     * $element->removeEvent('click');
     *
     * // removes `onsubmit` attribute with an enum key
     * $element->removeEvent(Event::SUBMIT);
     * ```
     */
    public function removeEvent(string|UnitEnum $event): static
    {
        $normalizedKey = Enum::normalizeValue($event);

        if (is_string($normalizedKey) === false || $normalizedKey === '') {
            throw new InvalidArgumentException(
                Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(),
            );
        }

        if (str_starts_with($normalizedKey, 'on') === false) {
            throw new InvalidArgumentException(
                Message::EVENT_KEY_MUST_START_WITH_ON->getMessage($normalizedKey),
            );
        }

        $new = clone $this;
        unset($new->attributes[$normalizedKey]);

        return $new;
    }

    /**
     * Internal method to set a single global `on*` event attribute.
     *
     * Modifies the current instance by setting or removing the specified event attribute, supporting string, Closure
     * and UnitEnum values.
     *
     * @param mixed $key Event key (string or UnitEnum).
     * @param Closure|string|Stringable|UnitEnum|null $handler Handler string or `null` to unset.
     *
     * @throws InvalidArgumentException if the key is invalid.
     *
     * @return static Current instance with the updated event attribute.
     *
     * @phpstan-param string|Stringable|Closure(): mixed|null $handler
     */
    private function addEventInternal(mixed $key, string|Closure|Stringable|UnitEnum|null $handler): static
    {
        $normalizedKey = Enum::normalizeValue($key);

        if (is_string($normalizedKey) === false || $normalizedKey === '') {
            throw new InvalidArgumentException(Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage());
        }


        if (str_starts_with($normalizedKey, 'on') === false) {
            throw new InvalidArgumentException(
                Message::EVENT_KEY_MUST_START_WITH_ON->getMessage($normalizedKey),
            );
        }

        if ($handler instanceof Closure) {
            $handler = $handler();
        }

        if (is_bool($handler)) {
            $handler = $handler ? 'true' : 'false';
        }

        if ($handler === null) {
            unset($this->attributes[$normalizedKey]);
        } else {
            $this->attributes[$normalizedKey] = $handler;
        }

        return $this;
    }
}
