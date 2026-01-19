<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Base;

use PHPForge\Support\LineEndingNormalizer;
use PHPUnit\Framework\Attributes\{Group, RequiresPhp};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Interop\{Block, Inline};
use UIAwesome\Html\Mixin\{HasAttributes, HasContent};

/**
 * Unit tests for {@see BaseTag} rendering and lifecycle behavior.
 *
 * Verifies lifecycle-driven rendering behavior for {@see BaseTag}.
 *
 * Test coverage.
 * - Renders begin/end output when `begin()` and `end()` are supported by the tag.
 * - Skips rendering when `beforeRun()` returns `false`.
 *
 * {@see BaseTag} for implementation details.
 * {@see TestSupport} for assertion utilities.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
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

    #[RequiresPhp('8.4')]
    public function testRenderBegin(): void
    {
        $tag = new class extends BaseTag {
            use HasAttributes;
            use HasContent;

            protected function getTag(): Block
            {
                return Block::DIV;
            }

            protected function run(): string
            {
                if ($this->isBeginExecuted() === false) {
                    return Html::element($this->getTag(), $this->getContent(), $this->attributes);
                }

                return Html::end($this->getTag());
            }

            #[\Override]
            protected function runBegin(): string
            {
                return Html::begin($this->getTag(), $this->attributes);
            }
        };

        self::assertEquals(
            <<<HTML
            <div>
            Content
            </div>
            HTML,
            LineEndingNormalizer::normalize($tag->begin() . 'Content' . $tag::end()),
            'Expected correct rendering of begin and end tags.',
        );
    }
}
