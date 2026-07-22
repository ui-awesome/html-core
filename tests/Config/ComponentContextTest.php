<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Config;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Config\ComponentContext;
use UIAwesome\Html\Core\Exception\Message;

/**
 * Unit tests for the {@see ComponentContext} class.
 */
#[Group('config')]
final class ComponentContextTest extends TestCase
{
    public function testPreservesUnicodeComponentIdentifier(): void
    {
        $context = new ComponentContext('field.là');

        self::assertSame(
            'field.là',
            $context->component,
            'Failed asserting that a Unicode component identifier is preserved.',
        );
    }

    public function testReturnsSemanticValues(): void
    {
        $context = new ComponentContext(
            'field.control.email',
            variant: 'floating',
            size: 'medium',
            scheme: 'dark',
            states: ['invalid', 'disabled'],
            metadata: ['maxlength' => 255, 'nullable' => null],
        );

        self::assertSame(
            'field.control.email',
            $context->component,
            'Failed asserting that the component identifier is preserved.',
        );
        self::assertSame(
            'floating',
            $context->variant,
            'Failed asserting that the variant qualifier is preserved.',
        );
        self::assertSame(
            'medium',
            $context->size,
            'Failed asserting that the size qualifier is preserved.',
        );
        self::assertSame(
            'dark',
            $context->scheme,
            'Failed asserting that the scheme qualifier is preserved.',
        );
        self::assertTrue(
            $context->hasState('invalid'),
            'Failed asserting that an active state is reported as present.',
        );
        self::assertFalse(
            $context->hasState('valid'),
            'Failed asserting that a missing state is reported as absent.',
        );
        self::assertSame(
            255,
            $context->get('maxlength'),
            'Failed asserting that metadata values are returned by key.',
        );
        self::assertNull(
            $context->get('nullable', 'default'),
            'Failed asserting that a stored `null` metadata value takes precedence over the default.',
        );
        self::assertSame(
            'default',
            $context->get('missing', 'default'),
            'Failed asserting that the default value is returned for missing metadata keys.',
        );
    }

    public function testThrowInvalidArgumentExceptionForAssociativeStates(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::COMPONENT_STATES_MUST_BE_STRING_LIST->getMessage(),
        );

        new ComponentContext('field', states: ['state' => 'invalid']);
    }

    public function testThrowInvalidArgumentExceptionForComponentWithInteriorWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Component identifier'),
        );

        new ComponentContext('field control');
    }

    public function testThrowInvalidArgumentExceptionForComponentWithUnicodeWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Component identifier'),
        );

        new ComponentContext("\u{200B}field");
    }

    public function testThrowInvalidArgumentExceptionForEmptyComponent(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Component identifier'),
        );

        new ComponentContext('');
    }

    public function testThrowInvalidArgumentExceptionForEmptyMetadataKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::COMPONENT_METADATA_KEYS_MUST_BE_NON_EMPTY_STRINGS->getMessage(),
        );

        new ComponentContext('field', metadata: ['' => 'value']);
    }

    public function testThrowInvalidArgumentExceptionForEmptyState(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Component state'),
        );

        new ComponentContext('field', states: ['']);
    }

    public function testThrowInvalidArgumentExceptionForInvalidScheme(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Scheme'),
        );

        new ComponentContext('field', scheme: ' ');
    }

    public function testThrowInvalidArgumentExceptionForInvalidSize(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Size'),
        );

        new ComponentContext('field', size: ' ');
    }

    public function testThrowInvalidArgumentExceptionForInvalidVariant(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Variant'),
        );

        new ComponentContext('field', variant: ' ');
    }

    public function testThrowInvalidArgumentExceptionForNonStringState(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::COMPONENT_STATES_MUST_BE_STRING_LIST->getMessage(),
        );

        new ComponentContext('field', states: [1]);
    }
}
