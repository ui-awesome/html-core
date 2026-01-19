<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Provider\ThemeProviderInterface;

/**
 * Stub theme provider for tests.
 *
 * Returns deterministic theme configuration used by tests that verify theme application.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class DefaultThemeProvider implements ThemeProviderInterface
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
     */
    public function apply(BaseTag $tag, string $theme): array
    {
        if ($tag instanceof TagBlock) {
            return match ($theme) {
                'default' => ['class' => 'tag-default'],
                'primary' => ['class' => 'tag-primary'],
                'secondary' => ['class' => 'tag-secondary'],
                default => [],
            };
        }

        return match ($theme) {
            'highlight' => ['style' => 'background-color: yellow;'],
            'muted' => ['class' => 'text-muted'],
            default => [],
        };
    }
}
