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
 * Unit tests for whitespace-sensitive {@see BaseBlock} rendering.
 *
 * {@see BlockWhitespaceProvider} for test case data providers.
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

    public function testPreBeginEndAllowsCallerSuppliedProtection(): void
    {
        $pre = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::PRE;
            }
        };

        self::assertSame(
            "<pre>\n\nalpha</pre>",
            $pre->begin() . "\n" . "\nalpha" . $pre::end(),
            'A caller-supplied protective LF must remain separate from the content LF.',
        );
    }

    #[DataProviderExternal(BlockWhitespaceProvider::class, 'preStream')]
    public function testPreBeginEndKeepsContentBytes(string $content, string $expected): void
    {
        $pre = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::PRE;
            }
        };

        self::assertSame(
            $expected,
            $pre->begin() . $content . $pre::end(),
            'Streaming delimiters must not insert or remove content bytes.',
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

    public function testStreamedPreInsideBlockPreservesRawContentAndAttributes(): void
    {
        $pre = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::PRE;
            }
        };

        self::assertSame(
            "<div>\n<pre title=\"A &amp; B\">\r<span>alpha</span>\r</pre>\n</div>",
            TagBlock::tag()->begin()
                . $pre->title('A & B')->begin()
                . "\r<span>alpha</span>\r"
                . $pre::end()
                . TagBlock::end(),
            'Streaming must retain raw markup, attributes and CR bytes inside the enclosing block.',
        );
    }

    public function testStreamedTextareaInsideBlockPreservesExplicitNewlines(): void
    {
        $textarea = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::TEXT_AREA;
            }
        };

        self::assertSame(
            "<div>\n<textarea id=\"comment\">\r\nalpha\r\n\r\n</textarea>\n</div>",
            TagBlock::tag()->begin()
                . $textarea->id('comment')->begin()
                . "\r\nalpha\r\n\r\n"
                . $textarea::end()
                . TagBlock::end(),
            'Streaming must retain explicit CRLF bytes without adding a closing newline.',
        );
    }

    public function testTextareaBeginEndAllowsCallerSuppliedProtection(): void
    {
        $textarea = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::TEXT_AREA;
            }
        };

        self::assertSame(
            "<textarea>\n\r\nalpha</textarea>",
            $textarea->begin()
                . "\n"
                . "\r\nalpha"
                . $textarea::end(),
            'A caller-supplied protective LF must remain separate from the content CRLF.',
        );
    }

    #[DataProviderExternal(BlockWhitespaceProvider::class, 'textareaStream')]
    public function testTextareaBeginEndKeepsContentBytes(string $content, string $expected): void
    {
        $textarea = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::TEXT_AREA;
            }
        };

        self::assertSame(
            $expected,
            $textarea->begin() . $content . $textarea::end(),
            'Streaming delimiters must not insert or remove content bytes.',
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

    public function testTwoEnclosingBlocksPreservePreLeadingCrAndRawMarkup(): void
    {
        $pre = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::PRE;
            }
        };

        self::assertSame(
            "<div>\n<div>\n<pre title=\"A &amp; B\">\n\r<span>alpha</span>\r\r</pre>\n</div>\n</div>",
            TagBlock::tag()
                ->html(
                    TagBlock::tag()
                        ->html($pre->title('A & B')
                        ->html("\r<span>alpha</span>\r\r"))
                )
                ->render(),
            'Enclosing blocks must retain raw markup, attributes and the protective LF before CR.',
        );
    }

    public function testTwoEnclosingBlocksPreserveTextareaLeadingCrLfAndEscaping(): void
    {
        $textarea = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::TEXT_AREA;
            }
        };

        self::assertSame(
            "<div>\n<div>\n<textarea id=\"comment\">\n\r\nA &amp; &lt;b&gt; &amp;amp;\r\n</textarea>\n</div>\n</div>",
            TagBlock::tag()
                ->html(
                    TagBlock::tag()
                        ->html($textarea->id('comment')
                        ->content("\r\nA & <b> &amp;\r\n")),
                )
                ->render(),
            'Enclosing blocks must retain encoded text, attributes and the protective LF before CRLF.',
        );
    }
}
