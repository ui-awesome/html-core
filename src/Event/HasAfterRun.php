<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Event;

/**
 * Trait that defines a post-render hook.
 *
 * Provides {@see HasAfterRun::afterRun()} as an extension point for transforming the rendered output after
 * {@see \UIAwesome\Html\Core\Base\BaseTag::run()} has produced a result.
 *
 * Intended for tag implementations that need to post-process the rendered string (for example, whitespace
 * normalization).
 *
 * Key features.
 * - Provides an overridable `afterRun()` hook that returns the final string.
 * - Receives the rendered result and must return a `string`.
 * - Used by {@see \UIAwesome\Html\Core\Base\BaseTag::render()} to wrap core rendering.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasAfterRun
{
    /**
     * Handles logic to be executed after tag rendering.
     *
     * This method can be overridden to implement custom post-processing of the rendered result.
     *
     * @param string $result Rendered HTML output from the tag.
     *
     * @return string Post-processed HTML output.
     *
     * Usage example:
     * ```php
     * protected function afterRun(string $result): string
     * {
     *     // Custom post-processing logic here
     *     return $result;
     * }
     * ```
     */
    protected function afterRun(string $result): string
    {
        return $result;
    }
}
