<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Event;

/**
 * Trait for handling pre-render events in tag rendering.
 *
 * Provides a standards-compliant, immutable API for executing logic before the rendering of HTML tags, supporting
 * extension points for pre-processing or conditional rendering.
 *
 * Intended for use in tag and component systems that require hooks or event handling prior to tag rendering, ensuring
 * consistent and predictable pre-render behavior.
 *
 * Key features.
 * - Designed for use in tag rendering systems.
 * - Enables pre-processing or conditional logic before rendering HTML output.
 * - Immutable method for customizing pre-render logic.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
trait HasBeforeRun
{
    /**
     * Handles logic to be executed before tag rendering.
     *
     * This method can be overridden to implement custom pre-processing or to conditionally prevent rendering.
     *
     * @return bool Returns `true` to continue rendering, or `false` to skip rendering.
     *
     * Usage example:
     * ```php
     * protected function beforeRun(): bool
     * {
     *     // Custom pre-processing logic here
     *     return true; // or false to skip rendering
     * }
     * ```
     */
    protected function beforeRun(): bool
    {
        return true;
    }
}
