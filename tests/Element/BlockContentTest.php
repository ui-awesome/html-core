<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Contracts\Element\{ClearableContentInterface, ContentInterface};
use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Interop\Block;

/**
 * Unit tests for immutable content clearing through the public {@see BaseBlock} API.
 */
#[Group('element')]
final class BlockContentTest extends TestCase
{
    public function testClearContentPreservesOriginalTextareaAndAttributes(): void
    {
        $textarea = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::TEXT_AREA;
            }
        };

        $original = $textarea
            ->id('message')
            ->content('<old>')
            ->html('&amp;');

        self::assertInstanceOf(
            ClearableContentInterface::class,
            $original,
            'Original content must support clearing.',
        );
        self::assertInstanceOf(
            ContentInterface::class,
            $original,
            'Original content must remain readable.',
        );

        $cleared = $original->clearContent();

        self::assertNotSame(
            $original,
            $cleared,
            'Clearing must return a new instance.',
        );
        self::assertSame(
            '',
            $cleared->getContent(),
            'Encoded and raw content must both be cleared.',
        );
        self::assertSame(
            $original->getAttributes(),
            $cleared->getAttributes(),
            'Attributes must remain unchanged.',
        );
        self::assertSame(
            "<textarea id=\"message\">\n</textarea>",
            $cleared->render(),
            'Empty textarea rendering must retain its attributes.',
        );
        self::assertSame(
            '<textarea id="message">&lt;old&gt;&amp;</textarea>',
            $original->render(),
            'The original textarea must retain its encoded and raw content.',
        );

        $clearedAgain = $cleared->clearContent();

        self::assertNotSame(
            $cleared,
            $clearedAgain,
            'Clearing empty content must still return a new instance.',
        );
        self::assertSame(
            $cleared->render(),
            $clearedAgain->render(),
            'Repeated clearing must preserve empty markup.',
        );
    }

    public function testClearedTextareaSupportsEncodedAndRawAppends(): void
    {
        $textarea = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::TEXT_AREA;
            }
        };

        $cleared = $textarea
            ->content('stale')
            ->clearContent();
        $appended = $cleared
            ->content('<new>')
            ->content('&next')
            ->html('&amp;');

        self::assertSame(
            '',
            $cleared->getContent(),
            'Appending must not mutate the cleared instance.',
        );
        self::assertSame(
            '&lt;new&gt;&amp;next&amp;',
            $appended->getContent(),
            'Encoded and raw appends must preserve their original semantics after clearing.',
        );
        self::assertSame(
            '<textarea>&lt;new&gt;&amp;next&amp;</textarea>',
            $appended->render(),
            'Rendering must not restore stale content or encode appended text twice.',
        );
    }
}
