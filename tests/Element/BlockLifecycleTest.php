<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use Fiber;
use LogicException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use RuntimeException;
use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Tests\Provider\BlockLifecycleProvider;
use UIAwesome\Html\Core\Tests\Support\Stub\TagBlock;
use UIAwesome\Html\Interop\Block;

/**
 * Unit tests for operation-local {@see BaseBlock} lifecycle state.
 *
 * {@see BlockLifecycleProvider} for lifecycle failure and suspension phases.
 */
#[Group('element')]
final class BlockLifecycleTest extends TestCase
{
    public function testAbandonedFiberDoesNotLeaveBuilderInClosingMode(): void
    {
        $tag = TagBlock::tag()->content('builder');

        $fiber = new Fiber(
            static function () use ($tag): void {
                $tag->begin();
                Fiber::suspend();
            }
        );

        $fiber->start();

        unset($fiber);

        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $tag->render(),
            'Abandoned fiber should not leave the builder in closing mode.',
        );
    }

    public function testCloneWithIdenticalPropertiesHasNoOpenOperation(): void
    {
        $tag = TagBlock::tag()->content('builder');

        $opening = $tag->begin();

        $clone = clone $tag;

        $rendered = $clone->render();

        $closing = TagBlock::end();

        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $rendered,
            'Clone should not have an open operation.',
        );
        self::assertSame(
            <<<HTML
            <div>
            stream
            </div>
            HTML,
            "{$opening}stream{$closing}",
            'Opening and closing should wrap the stream content correctly.',
        );
        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $clone->render(),
            'Clone should still render correctly after failure and recovery.',
        );
    }

    #[DataProviderExternal(BlockLifecycleProvider::class, 'failures')]
    public function testExceptionConsumesOnlyItsOperationAndAllowsRecovery(string $phase): void
    {
        $tag = new class extends BaseBlock {
            public string $failure = '';

            protected function afterRun(string $result): string
            {
                if ($this->failure === 'after') {
                    throw new RuntimeException('after');
                }

                return parent::afterRun($result);
            }

            protected function beforeRun(): bool
            {
                if ($this->failure === 'before') {
                    throw new RuntimeException('before');
                }

                return parent::beforeRun();
            }

            protected function getTag(): Block
            {
                return Block::DIV;
            }

            protected function run(): string
            {
                if ($this->failure === 'run') {
                    throw new RuntimeException('run');
                }

                return parent::run();
            }

            protected function runBegin(): string
            {
                if ($this->failure === 'begin') {
                    throw new RuntimeException('begin');
                }

                return parent::runBegin();
            }
        };

        $tag = $tag->content('builder');
        $opening = $tag->begin();

        if ($phase !== 'begin') {
            $tag->begin();
        }

        $tag->failure = $phase;
        $message = '';

        try {
            if ($phase === 'begin') {
                $tag->begin();
            } else {
                $tag::end();
            }
        } catch (RuntimeException $exception) {
            $message = $exception->getMessage();
        } finally {
            $tag->failure = '';
        }

        $clone = $tag
            ->content('clone')
            ->render();
        $closing = $tag::end();
        $reused = $tag->begin() . 'again' . $tag::end();

        self::assertSame(
            $phase,
            $message,
            "Unexpected message for phase: {$phase} {$reused}",
        );
        self::assertSame(
            <<<HTML
            <div>
            builderclone
            </div>
            HTML,
            $clone,
            "Unexpected message for phase: $phase",
        );
        self::assertSame(
            <<<HTML
            <div>
            body
            </div>
            HTML,
            "{$opening}body{$closing}",
            "Unexpected message for phase: {$phase}",
        );
        self::assertSame(
            <<<HTML
            <div>
            again
            </div>
            HTML,
            $reused,
            "Unexpected message for phase: {$phase}",
        );
        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $tag->render(),
            "Unexpected message for phase: {$phase}",
        );

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            Message::UNEXPECTED_END_CALL_NO_BEGIN->getMessage($tag::class),
        );

        $tag::end();
    }

    public function testMismatchedEndLeavesBothOperationsAvailable(): void
    {
        $inner = new class extends BaseBlock {
            protected function getTag(): Block
            {
                return Block::ARTICLE;
            }
        };

        $opening = TagBlock::tag()->begin() . $inner->begin();

        $message = '';

        try {
            TagBlock::end();
        } catch (RuntimeException $exception) {
            $message = $exception->getMessage();
        }

        $result = "{$opening}body" . $inner::end() . TagBlock::end();

        self::assertSame(
            Message::TAG_CLASS_MISMATCH_ON_END->getMessage($inner::class, TagBlock::class),
            $message,
            'Unexpected message for phase: mismatched end',
        );
        self::assertSame(
            <<<HTML
            <div>
            <article>
            body
            </article>
            </div>
            HTML,
            $result,
            'Unexpected result for mismatched end',
        );
    }

    public function testNestedInstancesKeepTheirOwnContentAndAttributes(): void
    {
        $outer = TagBlock::tag()
            ->id('outer')
            ->content('outer builder');
        $inner = TagBlock::tag()
            ->id('inner')
            ->content('inner builder');

        $result = $outer->begin() . $inner->begin() . 'body' . TagBlock::end() . TagBlock::end();

        self::assertSame(
            <<<HTML
            <div id="outer">
            <div id="inner">
            body
            </div>
            </div>
            HTML,
            $result,
            'Unexpected result for nested instances',
        );
        self::assertSame(
            <<<HTML
            <div id="outer">
            outer builder
            </div>
            HTML,
            $outer->render(),
            'Unexpected result for outer render',
        );
        self::assertSame(
            <<<HTML
            <div id="inner">
            inner builder
            </div>
            HTML,
            $inner->render(),
            'Unexpected result for inner render',
        );
    }

    public function testOpenReceiverRetainsClosingModeOnlyInItsOwnContext(): void
    {
        $tag = TagBlock::tag()->content('builder');

        $opening = $tag->begin();
        $direct = $tag->render();

        $fiber = new Fiber(
            static function () use ($tag): string {
                $direct = $tag->render();
                $opening = $tag->begin();

                Fiber::suspend($opening);

                return "{$direct}{$opening}fiber" . TagBlock::end();
            }
        );

        $fiberOpening = $fiber->start();

        $closing = TagBlock::end();

        $fiber->resume();

        self::assertSame(
            "\n</div>",
            $direct,
            'Direct rendering should expose only the closing tag.',
        );
        self::assertSame(
            "<div>\n",
            $fiberOpening,
            'Fiber should retain its own opening mode.',
        );
        self::assertSame(
            <<<HTML
            <div>
            main
            </div>
            HTML,
            "{$opening}main$closing",
            'Main context should keep its own operation.',
        );
        self::assertSame(
            <<<HTML
            <div>
            builder
            </div><div>
            fiber
            </div>
            HTML,
            $fiber->getReturn(),
            'Suspended operations should remain isolated by fiber.',
        );
        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $tag->render(),
            'Builder content should remain unchanged.',
        );
    }

    public function testReentrantEndPreservesOuterHookStateAndIndependentClones(): void
    {
        $tag = new class extends BaseBlock {
            public bool $closeOuter = true;

            public bool $closingAfterNestedEnd = false;

            protected function afterRun(string $result): string
            {
                if ($this->closeOuter) {
                    $this->closeOuter = false;

                    $result .= self::end();

                    $this->closingAfterNestedEnd = $this->isBeginExecuted();

                    $clone = clone $this;

                    $result .= $clone->render();
                }

                return parent::afterRun($result);
            }

            protected function getTag(): Block
            {
                return Block::DIV;
            }
        };

        $tag = $tag->content('builder');
        $result = $tag->begin() . $tag->begin() . 'body' . $tag::end();

        self::assertSame(
            <<<HTML
            <div>
            <div>
            body
            </div>
            </div><div>
            builder
            </div>
            HTML,
            $result,
            'Outer output should include the nested close and independent clone.',
        );
        self::assertTrue(
            $tag->closingAfterNestedEnd,
            'Outer closing state should survive the nested end.',
        );
        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $tag->render(),
            'Clone rendering should not consume original state.',
        );
    }

    public function testRepeatedBeginClosesEachOperationAndKeepsBuilderReusable(): void
    {
        $tag = TagBlock::tag()->content('builder');

        $result = $tag->begin() . $tag->begin() . 'body' . TagBlock::end() . TagBlock::end();

        self::assertSame(
            <<<HTML
            <div>
            <div>
            body
            </div>
            </div>
            HTML,
            $result,
            'Each begin operation should close in order.'
        );
        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $tag->render(),
            'Builder content should remain reusable.'
        );
        self::assertSame(
            <<<HTML
            <div>
            again
            </div>
            HTML,
            $tag->begin() . 'again' . TagBlock::end(),
            'A later operation should render independently.',
        );
    }

    public function testSetterCloneRendersIndependentlyBeforeAndAfterOriginalEnd(): void
    {
        $tag = TagBlock::tag()->content('builder');

        $opening = $tag->begin();
        $clone = $tag
            ->class('child')
            ->content('inner');
        $beforeEnd = $clone->render();
        $result = $opening . $clone->begin() . 'stream' . TagBlock::end() . TagBlock::end();

        self::assertSame(
            <<<HTML
            <div class="child">
            builderinner
            </div>
            HTML,
            $beforeEnd,
            'Clone should retain its builder content.',
        );
        self::assertSame(
            <<<HTML
            <div>
            <div class="child">
            stream
            </div>
            </div>
            HTML,
            $result,
            'Nested clone output should remain correctly wrapped.',
        );
        self::assertSame(
            <<<HTML
            <div class="child">
            builderinner
            </div>
            HTML,
            $clone->render(),
            'Clone state should remain independent after closing.',
        );
        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $tag->render(),
            'Original builder state should remain unchanged.'
        );
    }

    public function testSkippedClosingHookConsumesOnlyItsOperation(): void
    {
        $tag = new class extends BaseBlock {
            public bool $skip = true;

            protected function beforeRun(): bool
            {
                if ($this->skip) {
                    $this->skip = false;

                    return false;
                }

                return parent::beforeRun();
            }

            protected function getTag(): Block
            {
                return Block::DIV;
            }
        };

        $tag = $tag->content('builder');
        $tag->begin();
        $tag->begin();
        $skipped = $tag::end();
        $closing = $tag::end();

        self::assertSame(
            '',
            $skipped,
            'Skipped hook should emit no closing output.',
        );
        self::assertSame(
            "\n</div>",
            $closing,
            'The next operation should still close normally.',
        );
        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $tag->render(),
            'Builder content should remain available.',
        );
    }

    #[DataProviderExternal(BlockLifecycleProvider::class, 'hooks')]
    public function testSuspendedClosingHooksDoNotShareStateBetweenContexts(string $phase): void
    {
        $tag = new class extends BaseBlock {
            public string $suspendAt = '';

            protected function afterRun(string $result): string
            {
                if ($this->suspendAt === 'after' && Fiber::getCurrent() !== null) {
                    Fiber::suspend();
                }

                return parent::afterRun($result);
            }

            protected function beforeRun(): bool
            {
                if ($this->suspendAt === 'before' && Fiber::getCurrent() !== null) {
                    Fiber::suspend();
                }

                return parent::beforeRun();
            }

            protected function getTag(): Block
            {
                return Block::DIV;
            }

            protected function run(): string
            {
                if ($this->suspendAt === 'run' && Fiber::getCurrent() !== null) {
                    Fiber::suspend();
                }

                return parent::run();
            }
        };

        $tag = $tag->content('builder');

        $tag->suspendAt = $phase;

        $first = new Fiber(
            static fn(): string => $tag->begin() . 'first' . $tag::end(),
        );
        $second = new Fiber(
            static fn(): string => $tag->begin() . 'second' . $tag::end(),
        );

        $first->start();
        $second->start();
        $direct = $tag->render();
        $main = $tag->begin() . 'main' . $tag::end();
        $second->resume();
        $first->resume();

        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $direct,
            'Direct rendering should remain independent of suspended hooks.',
        );
        self::assertSame(
            <<<HTML
            <div>
            main
            </div>
            HTML,
            $main,
            'Main context should retain its own operation.',
        );
        self::assertSame(
            <<<HTML
            <div>
            first
            </div>
            HTML,
            $first->getReturn(),
            'First fiber should retain its own operation.',
        );
        self::assertSame(
            <<<HTML
            <div>
            second
            </div>
            HTML,
            $second->getReturn(),
            'Second fiber should retain its own operation.',
        );
        self::assertSame(
            <<<HTML
            <div>
            builder
            </div>
            HTML,
            $tag->render(),
            'Builder content should remain unchanged.'
        );
    }
}
