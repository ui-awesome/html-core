<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Core\Tag\Block;

final class TagBlock extends BaseBlock
{
    /**
     * Returns the tag enumeration for the `<div>` element.
     *
     * @return Block Tag enumeration instance for `<div>`.
     */
    protected function getTag(): Block
    {
        return Block::DIV;
    }
}
