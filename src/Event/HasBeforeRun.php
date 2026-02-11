<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Event;

/**
 * Provides a pre-render lifecycle hook.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasBeforeRun
{
    /**
     * Validates state before rendering.
     *
     * Usage example:
     * ```php
     * protected function beforeRun(): bool
     * {
     *     return true;
     * }
     * ```
     *
     * @return bool Returns `true` to continue rendering, or `false` to skip rendering.
     */
    protected function beforeRun(): bool
    {
        return true;
    }
}
