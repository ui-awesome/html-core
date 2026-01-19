<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Provider;

use UIAwesome\Html\Core\Base\BaseTag;

/**
 * Interface for providing default configuration values for tag instances.
 *
 * Defines a contract for classes that return cookbook-style configuration arrays for {@see BaseTag} objects. The
 * returned definitions are applied by {@see \UIAwesome\Html\Core\Base\BaseTag::addDefaultProvider()}.
 *
 * Intended for use in factories or component systems that need a consistent way to supply per-tag defaults.
 *
 * Key features.
 * - Centralizes default configuration logic for tag instances.
 * - Enables reusable initialization definitions for multiple tag classes.
 * - Returns configuration arrays consumed by {@see \UIAwesome\Html\Core\Factory\SimpleFactory::configure()}.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
interface DefaultsProviderInterface
{
    /**
     * Returns configuration defaults for the given tag instance.
     *
     * Provides a cookbook-style associative array of default values for the specified tag, supporting extensible and
     * consistent tag configuration across the system.
     *
     * @param BaseTag $tag Tag instance being configured.
     *
     * @return array Cookbook-style configuration array.
     *
     * @phpstan-return mixed[]
     *
     * Usage example:
     * ```php
     * public function getDefaults(BaseTag $tag): array
     * {
     *     return [
     *         'class' => 'default-class',
     *         'data' => ['value' => 'default-value'],
     *     ];
     * }
     * ```
     */
    public function getDefaults(BaseTag $tag): array;
}
