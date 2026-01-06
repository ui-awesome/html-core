<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Interop\Block;
use UIAwesome\Html\Interop\BlockInterface;

/**
 * Provides a test stub for a block tag implementation.
 *
 * Supplies a minimal {@see BaseBlock} implementation that always resolves to the `<div>` tag, supporting deterministic
 * assertions in unit tests involving block element rendering.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TagBlock extends BaseBlock
{
    /**
     * Returns the tag enumeration for the `<div>` element.
     *
     * @return BlockInterface Tag enumeration instance for `<div>`.
     */
    protected function getTag(): BlockInterface
    {
        return Block::DIV;
    }
}
