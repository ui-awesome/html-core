<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Tag;

use UIAwesome\Html\Core\Tag;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ImmutableTest extends \PHPUnit\Framework\TestCase
{
    public function testImmutable(): void
    {
        $instance = Tag::widget();

        $this->assertNotSame($instance, $instance->tokenValues([]));
    }
}
