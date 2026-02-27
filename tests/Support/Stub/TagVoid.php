<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use BackedEnum;
use UIAwesome\Html\Core\Element\BaseVoid;
use UIAwesome\Html\Interop\Voids;

/**
 * Stub for a void tag implementation.
 *
 * Supplies a minimal {@see BaseVoid} implementation that always resolves to the `<hr>` tag, supporting deterministic
 * assertions in unit tests involving void element rendering.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TagVoid extends BaseVoid
{
    /**
     * Returns the tag enumeration for the `<hr>` element.
     *
     * Provides the tag enumeration instance used by the base void element to determine the tag name to render.
     *
     * @return BackedEnum Tag enumeration instance for `<hr>`.
     */
    protected function getTag(): BackedEnum
    {
        return Voids::HR;
    }
}
