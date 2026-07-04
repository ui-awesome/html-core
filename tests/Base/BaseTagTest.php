<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Base;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Interop\Inline;
use UIAwesome\Html\Mixin\HasAttributes;

/**
 * Unit tests for the {@see BaseTag} class.
 */
#[Group('base')]
final class BaseTagTest extends TestCase
{
    public function testBeforeRunReturnFalse(): void
    {
        $tag = new class extends BaseTag {
            use HasAttributes;

            protected function getTag(): Inline
            {
                return Inline::SPAN;
            }

            protected function beforeRun(): bool
            {
                return false;
            }

            protected function run(): string
            {
                return Html::inline($this->getTag(), '', $this->attributes);
            }
        };

        self::assertEmpty(
            $tag->render(),
            "Expected empty output when 'beforeRun()' method returns 'false'.",
        );
    }
}
