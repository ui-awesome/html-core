<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Event;

/**
 * Trait for handling post-render events in tag rendering.
 *
 * Provides a standards-compliant, immutable API for executing logic after the rendering of HTML tags, supporting
 * extension points for post-processing or modification of rendered output.
 *
 * Intended for use in tag and component systems that require hooks or event handling after tag rendering, ensuring
 * consistent and predictable post-render behavior.
 *
 * Key features.
 * - Designed for use in tag rendering systems.
 * - Enables post-processing of rendered HTML output.
 * - Immutable method for customizing post-render logic.
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
