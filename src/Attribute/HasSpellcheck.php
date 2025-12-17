<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Attribute;

use InvalidArgumentException;
use UIAwesome\Html\Helper\Validator;

use function is_bool;

/**
 * Trait for managing the global HTML `spellcheck` attribute in tag rendering.
 *
 * Provides a standards-compliant, immutable API for setting the `spellcheck` attribute on HTML elements, following the
 * HTML specification for global attributes.
 *
 * Intended for use in tags and components that require dynamic or programmatic manipulation of spellchecking behavior,
 * ensuring correct attribute handling, type safety, and value validation.
 *
 * Key features.
 * - Designed for use in tags and components.
 * - Enforces standards-compliant handling of the HTML `spellcheck` global attribute.
 * - Immutable method for setting or overriding the `spellcheck` attribute.
 * - Supports bool, string, and `null` for flexible spellcheck assignment.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/spellcheck
 * @property array $attributes HTML attributes array used by the implementing class.
 * @phpstan-property mixed[] $attributes
 * {@see \UIAwesome\Html\Core\Mixin\HasAttributes} for managing the underlying attributes array.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasSpellcheck
{
    /**
     * Sets the HTML `spellcheck` attribute for the element.
     *
     * Creates a new instance with the specified spellcheck value, supporting both explicit and nullable assignment
     * according to the HTML specification for global attributes.
     *
     * @param bool|string|null $value Spellcheck value to set for the element. Can be `null` to unset the attribute.
     *
     * @throws InvalidArgumentException if the provided value is not valid.
     *
     * @return static New instance with the updated `spellcheck` attribute.
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#attr-spellcheck
     *
     * Usage example:
     * ```php
     * // sets the `spellcheck` attribute to `false`
     * $element->spellcheck(false);
     *
     * // sets the `spellcheck` attribute to `true`
     * $element->spellcheck(true);
     * ```
     */
    public function spellcheck(bool|string|null $value): static
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes['spellcheck']);

            return $new;
        }

        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        Validator::oneOf($value, ['false', 'true'], 'spellcheck');

        $new->attributes['spellcheck'] = $value;

        return $new;
    }
}
