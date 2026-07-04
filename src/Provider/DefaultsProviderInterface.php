<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Provider;

use UIAwesome\Html\Core\Base\BaseTag;

/**
 * Defines defaults providers for tag instances.
 *
 * Usage example:
 * ```php
 * use UIAwesome\Html\Core\Base\BaseTag;
 * use UIAwesome\Html\Core\Provider\DefaultsProviderInterface;
 *
 * final class ButtonDefaultsProvider implements DefaultsProviderInterface
 * {
 *     public function getDefaults(BaseTag $tag): array
 *     {
 *         return ['class' => 'btn'];
 *     }
 * }
 * ```
 */
interface DefaultsProviderInterface
{
    /**
     * Returns configuration defaults for a tag instance.
     *
     * Usage example:
     * ```php
     * public function getDefaults(\UIAwesome\Html\Core\Base\BaseTag $tag): array
     * {
     *     return ['class' => 'default-class', 'data' => ['value' => 'default-value']];
     * }
     * ```
     *
     * @param BaseTag $tag Tag instance being configured.
     *
     * @return array Cookbook-style configuration array.
     *
     * @phpstan-return mixed[]
     */
    public function getDefaults(BaseTag $tag): array;
}
