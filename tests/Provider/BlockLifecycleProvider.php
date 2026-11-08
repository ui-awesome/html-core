<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Provider;

/**
 * Lifecycle phases for {@see \UIAwesome\Html\Core\Tests\Element\BlockLifecycleTest}.
 */
final class BlockLifecycleProvider
{
    /**
     * @phpstan-return array<string, array{string}>
     */
    public static function failures(): array
    {
        return [
            'after rendering' => ['after'],
            'before rendering' => ['before'],
            'opening hook' => ['begin'],
            'rendering' => ['run'],
        ];
    }

    /**
     * @phpstan-return array<string, array{string}>
     */
    public static function hooks(): array
    {
        return [
            'after rendering' => ['after'],
            'before rendering' => ['before'],
            'rendering' => ['run'],
        ];
    }
}
