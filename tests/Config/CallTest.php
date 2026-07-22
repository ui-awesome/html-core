<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Config;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Config\Call;
use UIAwesome\Html\Core\Exception\Message;

/**
 * Unit tests for the {@see Call} class.
 */
#[Group('config')]
final class CallTest extends TestCase
{
    public function testPreservesMethodAndOrderedArguments(): void
    {
        $call = new Call('addAttribute', 'data-role', ['field', 'control']);

        self::assertSame(
            'addAttribute',
            $call->method,
            'Failed asserting that the method name is preserved.',
        );
        self::assertSame(
            ['data-role', ['field', 'control']],
            $call->arguments,
            'Failed asserting that positional arguments are preserved in declaration order.',
        );
    }

    public function testPreservesUnicodeMethodName(): void
    {
        $call = new Call('clàss');

        self::assertSame(
            'clàss',
            $call->method,
            'Failed asserting that a Unicode method name is preserved.',
        );
    }

    public function testThrowInvalidArgumentExceptionForEmptyMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_METHOD_MUST_BE_NON_EMPTY->getMessage(),
        );

        new Call('');
    }

    public function testThrowInvalidArgumentExceptionForMethodWithInteriorWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_METHOD_MUST_BE_NON_EMPTY->getMessage(),
        );

        new Call('add attribute');
    }

    public function testThrowInvalidArgumentExceptionForMethodWithSurroundingWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_METHOD_MUST_BE_NON_EMPTY->getMessage(),
        );

        new Call(' class');
    }

    public function testThrowInvalidArgumentExceptionForMethodWithUnicodeWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_METHOD_MUST_BE_NON_EMPTY->getMessage(),
        );

        new Call("\u{00A0}class");
    }

    public function testThrowInvalidArgumentExceptionForNamedArguments(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_ARGUMENTS_MUST_BE_POSITIONAL_LIST->getMessage(),
        );

        new Call('class', value: 'field');
    }
}
