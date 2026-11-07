<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Core\Tests\Provider\BlockWhitespaceProvider;
use UIAwesome\Html\Core\Tests\Support\Stub\TagBlock;
use UIAwesome\Html\Interop\Block;

/**
 * Unit tests for the {@see TagBlock} element renderer.
 */
#[Group('element')]
final class BlockWhitespaceTest extends TestCase
{
    public function testEnclosingBlockDoesNotChangeTextareaValue(): void
    {
        $textarea = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::TEXT_AREA;
            }
        };

        self::assertSame(
            <<<HTML
            <div>
            <textarea>alpha\n\nbeta</textarea>
            </div>
            HTML,
            TagBlock::tag()->html($textarea->content("alpha\n\nbeta"))->render(),
            'Embedded line breaks must be preserved.',
        );
    }

    public function testOrdinaryBlockKeepsRendererDelimitersWithoutChangingContent(): void
    {
        self::assertSame(
            <<<HTML
            <div>
            alpha

            </div>
            HTML,
            TagBlock::tag()->content("alpha\n")->render(),
            'Trailing line breaks must remain part of the content.',
        );

        self::assertSame(
            <<<HTML
            <div>
            alpha
            </div>
            HTML,
            TagBlock::tag()->begin() . 'alpha' . TagBlock::end(),
            'Opening and closing delimiters must frame the content.',
        );
    }

    public function testPreBeginEndDoesNotAppendToItsText(): void
    {
        $pre = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::PRE;
            }
        };

        self::assertSame(
            <<<HTML
            <pre>alpha</pre>
            HTML,
            $pre->begin() . 'alpha' . $pre::end(),
            'Preformatted content must not gain surrounding line breaks.',
        );
    }

    #[DataProviderExternal(BlockWhitespaceProvider::class, 'preContent')]
    public function testPrePreservesItsText(string $content, string $expected): void
    {
        $pre = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::PRE;
            }
        };

        self::assertSame(
            $expected,
            $pre->content($content)->render(),
            'Preformatted markup must preserve the supplied whitespace.',
        );
    }

    public function testRendererClosingDelimiterDoesNotCorruptMultibyteText(): void
    {
        self::assertSame(
            <<<HTML
            <div>
            Å
            </div>
            HTML,
            TagBlock::tag()->content('Å')->render(),
            'Closing delimiters must preserve multibyte content.',
        );
    }

    public function testTextareaBeginEndDoesNotAddPresentationLineBreaks(): void
    {
        $textarea = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::TEXT_AREA;
            }
        };

        self::assertSame(
            <<<HTML
            <textarea>
            alpha
            </textarea>
            HTML,
            $textarea->begin() . "\nalpha\n" . $textarea::end(),
            'Textarea delimiters must not add presentation line breaks.',
        );
    }

    #[DataProviderExternal(BlockWhitespaceProvider::class, 'textareaContent')]
    public function testTextareaPreservesItsValue(string $content, string $expected): void
    {
        $textarea = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::TEXT_AREA;
            }
        };

        self::assertSame(
            $expected,
            $textarea->content($content)->render(),
            'Textarea markup must preserve the supplied value.',
        );
    }

    public function testTwoEnclosingBlocksDoNotChangeNestedPreText(): void
    {
        $pre = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::PRE;
            }
        };

        $inner = TagBlock::tag()->html($pre->content("\nalpha\n\nbeta"));

        self::assertSame(
            <<<HTML
            <div>
            <div>
            <pre>
            alpha
            beta</pre>
            </div>
            </div>
            HTML,
            TagBlock::tag()->html($inner)->render(),
            'Nested preformatted text must retain its whitespace.',
        );
    }
}
