<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Interop\Block;
use UIAwesome\Html\Interop\BlockInterface;

/**
 * Stub for a block tag with default definitions.
 *
 * Supplies a {@see BaseBlock} implementation that provides default definitions via
 * {@see TagBlockWithDefaults::loadDefault()}, supporting tests for default value application.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TagBlockWithDefaults extends BaseBlock
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

    /**
     * Returns default definitions for the tag.
     *
     * Provides default values that are applied when the tag is instantiated.
     *
     * @return array Default definitions.
     *
     * @phpstan-return mixed[]
     */
    protected function loadDefault(): array
    {
        return [
            'class' => 'default-class',
        ];
    }
}
