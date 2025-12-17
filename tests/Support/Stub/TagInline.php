<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Attribute\{HasContentEditable, HasDraggable, HasMicroData, HasTabindex};
use UIAwesome\Html\Core\Element\BaseInline;
use UIAwesome\Html\Core\Tag\Inline;

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
     * @return Inline Tag enumeration instance for `<span>`.
     */
    protected function getTag(): Inline
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
