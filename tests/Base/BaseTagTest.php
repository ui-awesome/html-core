<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Base;

use PHPUnit\Framework\Attributes\{Group, RequiresPhp};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Tests\Support\TestSupport;
use UIAwesome\Html\Interop\{Block, Inline};
use UIAwesome\Html\Mixin\{HasAttributes, HasContent};

/**
 * Test suite for {@see BaseTag} element functionality and behavior.
 *
 * Validates the management and rendering of the base HTML tag element according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling of the `beforeRun()` lifecycle method and its effect on rendering.
 *
 * {@see BaseTag} for element implementation details.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('base')]
final class BaseTagTest extends TestCase
{
    use TestSupport;

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

        self::equalsWithoutLE(
            <<<HTML
            <div>
            Content
            </div>
            HTML,
            $tag->begin() . 'Content' . $tag::end(),
            'Expected correct rendering of begin and end tags.',
        );
    }
}
