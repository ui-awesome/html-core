<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Provider;

use UIAwesome\Html\Core\Base\BaseTag;

/**
 * Interface for applying theme configurations to tag instances.
 *
 * Defines a contract for classes that return theme-based configuration arrays for {@see BaseTag} objects. The returned
 * definitions are applied by {@see \UIAwesome\Html\Core\Base\BaseTag::addThemeProvider()}.
 *
 * Intended for use in theme provider implementations that map a theme identifier to configuration definitions.
 *
 * Key features.
 * - Centralizes theme application logic for tag instances.
 * - Maps a theme identifier to configuration arrays.
 * - Returns configuration arrays consumed by {@see \UIAwesome\Html\Core\Factory\SimpleFactory::configure()}.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
interface ThemeProviderInterface
{
    /**
     * Applies theme configuration to the given tag instance.
     *
     * Returns an associative array of configuration values for the specified tag and theme, supporting extensible and
     * consistent theme application across the system.
     *
     * @param BaseTag $tag Tag instance to which the theme is applied.
     * @param string $theme Theme identifier to apply.
     *
     * @return array Associative array of theme configuration values.
     *
     * @phpstan-return mixed[]
     *
     * Usage example:
     * ```php
     * public function apply(BaseTag $tag, string $theme): array
     * {
     *     if ($tag instanceof ButtonTag === false) {
     *        return [];
     *     }
     *
     *     return match ($theme) {
     *         'dark' => ['class' => 'btn-dark'],
     *         'light' => ['class' => 'btn-light'],
     *         default => [],
     *     };
     * }
     * ```
     */
    public function apply(BaseTag $tag, string $theme): array;
}
