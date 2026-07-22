<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Config;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Config\{Call, Cookbook};
use UIAwesome\Html\Core\Exception\Message;

use function iterator_to_array;

/**
 * Unit tests for the {@see Cookbook} class.
 */
#[Group('config')]
final class CookbookTest extends TestCase
{
    public function testCreatesEmptyCookbook(): void
    {
        $cookbook = new Cookbook();

        self::assertCount(
            0,
            $cookbook,
            'Failed asserting that an empty cookbook has zero calls.',
        );
        self::assertSame(
            [],
            iterator_to_array($cookbook),
            'Failed asserting that iteration yields no calls.',
        );
        self::assertTrue(
            $cookbook->isEmpty(),
            'Failed asserting that an empty cookbook reports itself as empty.',
        );
    }

    public function testStoresDuplicateCallsInDeclarationOrder(): void
    {
        $first = new Call('class', 'base');
        $second = new Call('class', 'override');
        $cookbook = new Cookbook($first, $second);

        self::assertCount(
            2,
            $cookbook,
            'Failed asserting that both calls are stored.',
        );
        self::assertSame(
            [$first, $second],
            $cookbook->calls,
            'Failed asserting that calls are exposed in declaration order.',
        );
        self::assertSame(
            [$first, $second],
            iterator_to_array($cookbook),
            'Failed asserting that iteration preserves declaration order.',
        );
        self::assertFalse(
            $cookbook->isEmpty(),
            'Failed asserting that a populated cookbook is not empty.',
        );
    }

    public function testThrowInvalidArgumentExceptionForNamedCalls(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::COOKBOOK_CALLS_MUST_BE_POSITIONAL_LIST->getMessage(),
        );

        new Cookbook(first: new Call('class', 'field'));
    }
}
