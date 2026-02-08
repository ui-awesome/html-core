<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Element\BaseInput;
use UIAwesome\Html\Interop\{VoidInterface, Voids};

/**
 * Stub for input tag that exposes `buildElement()` with `tokenValues` parameter.
 *
 * Used to test the spread operator behavior in {@see BaseInput::buildElement()} when merging token template values
 * with additional token values.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TagInputWithTokenValues extends BaseInput
{
    /**
     * Additional token values to pass to {@see BaseInput::buildElement()}.
     *
     * @phpstan-var mixed[]
     */
    private array $tokenValues = [];

    /**
     * Sets additional token values for template rendering.
     *
     * @param array $tokenValues Additional token values.
     *
     * @return static New instance with the updated `tokenValues` value.
     *
     * @phpstan-param mixed[] $tokenValues
     */
    public function tokenValues(array $tokenValues): static
    {
        $new = clone $this;
        $new->tokenValues = $tokenValues;

        return $new;
    }

    /**
     * Returns the tag enumeration for the `<input>` element.
     *
     * @return VoidInterface Tag enumeration instance for `<input>`.
     */
    protected function getTag(): VoidInterface
    {
        return Voids::INPUT;
    }

    /**
     * Renders the `<input>` element with its attributes and token values.
     *
     * @return string Rendered HTML for the `<input>` element.
     */
    protected function run(): string
    {
        return $this->buildElement('', $this->tokenValues);
    }
}
