<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Provider\DefaultsProviderInterface;

/**
 * Stub defaults provider for tests.
 *
 * Returns deterministic default attributes used by tests that verify configuration precedence.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class DefaultProvider implements DefaultsProviderInterface
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
     */
    public function getDefaults(BaseTag $tag): array
    {
        return ['class' => 'default-provider'];
    }
}
