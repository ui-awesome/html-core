<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Event;

/**
 * Provides a post-render lifecycle hook.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasAfterRun
{
    /**
     * Post-processes rendered output.
     *
     * Usage example:
     * ```php
     * protected function afterRun(string $result): string
     * {
     *     return trim($result);
     * }
     * ```
     *
     * @param string $result Rendered HTML output from the tag.
     *
     * @return string Post-processed HTML output.
     */
    protected function afterRun(string $result): string
    {
        return $result;
    }
}
