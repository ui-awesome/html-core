<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Element\BaseVoid;
use UIAwesome\Html\Core\Tag\Voids;

/**
 * Provides a test stub for a void tag implementation.
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
     * @return Voids Tag enumeration instance for `<hr>`.
     */
    protected function getTag(): Voids
    {
        return Voids::HR;
    }
}
