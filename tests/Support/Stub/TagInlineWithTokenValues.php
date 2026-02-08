<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Element\BaseInline;
use UIAwesome\Html\Interop\{Inline, InlineInterface};

/**
 * Stub for inline tag that exposes `buildElement()` with `tokenValues` parameter.
 *
 * Used to test the spread operator behavior in {@see BaseInline::buildElement()} when merging token template values
 * with additional token values.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TagInlineWithTokenValues extends BaseInline
{
    /**
     * Additional token values to pass to {@see BaseInline::buildElement()}
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
     * Returns the tag enumeration for the `<span>` element.
     *
     * @return InlineInterface Tag enumeration instance for `<span>`.
     */
    protected function getTag(): InlineInterface
    {
        return Inline::SPAN;
    }

    /**
     * Renders the `<span>` element with its content, attributes and token values.
     *
     * @return string Rendered HTML for the `<span>` element.
     */
    protected function run(): string
    {
        return $this->buildElement($this->getContent(), $this->tokenValues);
    }
}
