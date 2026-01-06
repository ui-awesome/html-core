<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Attribute\{HasContentEditable, HasDraggable, HasMicroData, HasTabindex};
use UIAwesome\Html\Core\Element\BaseInline;
use UIAwesome\Html\Interop\Inline;
use UIAwesome\Html\Interop\InlineInterface;

/**
 * Provides a test stub for an inline tag implementation.
 *
 * Supplies a minimal {@see BaseInline} implementation that always resolves to the `<span>` tag, supporting
 * deterministic assertions in unit tests involving inline element rendering.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TagInline extends BaseInline
{
    use HasContentEditable;
    use HasDraggable;
    use HasMicroData;
    use HasTabindex;

    /**
     * Flag to indicate if the element has been rendered.
     */
    public bool $flag = false;

    /**
     * Internal flag to track if the element is disabled.
     *
     * @phpstan-ignore-next-line
     */
    private bool|null $flagDisabled = null;

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
     * Renders the `<span>` element with its content and attributes.
     *
     * @return string Rendered HTML for the `<span>` element.
     */
    protected function run(): string
    {
        return $this->buildElement($this->getContent());
    }
}
