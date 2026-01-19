<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Event;

/**
 * Trait that defines a pre-render hook.
 *
 * Provides {@see HasBeforeRun::beforeRun()} as an extension point for performing checks before
 * {@see \UIAwesome\Html\Core\Base\BaseTag::run()} executes.
 *
 * Intended for tag implementations that need to validate state or conditionally skip rendering by returning `false`.
 *
 * Key features.
 * - Provides an overridable `beforeRun()` hook used to gate rendering.
 * - Returns `true` to continue rendering, or `false` to skip rendering.
 * - Used by {@see \UIAwesome\Html\Core\Base\BaseTag::render()} before calling `run()`.
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
