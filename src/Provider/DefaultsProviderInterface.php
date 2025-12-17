<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Provider;

use UIAwesome\Html\Core\Base\BaseTag;

/**
 * Interface for providing default configuration values for tag instances.
 *
 * Defines a contract for classes that supply cookbook-style configuration arrays for HTML tag objects, enabling
 * consistent and extensible default value management across tag rendering systems.
 *
 * Intended for use in tag factories, theme providers, or component systems that require standardized initialization of
 * tag attributes, options, or behaviors.
 *
 * Key features.
 * - Centralizes default configuration logic for tag instances.
 * - Promotes maintainable and predictable tag initialization.
 * - Supports extensibility for custom tag types and rendering strategies.
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
