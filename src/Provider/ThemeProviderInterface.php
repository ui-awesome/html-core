<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Provider;

use UIAwesome\Html\Core\Base\BaseTag;

/**
 * Defines theme providers for tag instances.
 *
 * Usage example:
 * ```php
 * use UIAwesome\Html\Core\Base\BaseTag;
 * use UIAwesome\Html\Core\Provider\ThemeProviderInterface;
 *
 * final class ButtonThemeProvider implements ThemeProviderInterface
 * {
 *     public function apply(BaseTag $tag, string $theme): array
 *     {
 *         return $theme === 'dark' ? ['class' => 'btn-dark'] : [];
 *     }
 * }
 * ```
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
interface ThemeProviderInterface
{
    /**
     * Returns theme configuration for a tag instance.
     *
     * Usage example:
     * ```php
     * public function apply(\UIAwesome\Html\Core\Base\BaseTag $tag, string $theme): array
     * {
     *     return match ($theme) {
     *         'dark' => ['class' => 'btn-dark'],
     *         default => [],
     *     };
     * }
     * ```
     *
     * @param BaseTag $tag Tag instance to which the theme is applied.
     * @param string $theme Theme identifier to apply.
     *
     * @return array Associative array of theme configuration values.
     *
     * @phpstan-return mixed[]
     */
    public function apply(BaseTag $tag, string $theme): array;
}
