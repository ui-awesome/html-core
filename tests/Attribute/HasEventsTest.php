<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use Closure;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use stdClass;
use Stringable;
use UIAwesome\Html\Core\Attribute\HasEvents;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\EventProvider;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\Priority;
use UIAwesome\Html\Helper\Attributes;
use UnitEnum;

/**
 * Test suite for {@see HasEvents} trait functionality and behavior.
 *
 * Validates the management of global HTML `on*` event handler attributes according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of `on*` event attributes in tag rendering, supporting string,
 * Stringable, UnitEnum, and Closure for dynamic event handler assignment.
 *
 * Test coverage.
 * - Accurate rendering of attributes with `on*` event attributes.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Exception handling for invalid keys and values.
 * - Immutability of the trait's API when setting or overriding `on*` event attributes.
 * - Proper assignment and overriding of `on*` event handler values.
 * - Validation of `on` prefix enforcement for event attribute keys.
 *
 * {@see EventProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasEventsTest extends TestCase
{
    /**
     * @param mixed[] $data
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(EventProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithEventAttribute(
        array $data,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $instance = $instance->attributes($attributes)->events($data);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnNewInstanceWhenSettingEventAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        self::assertNotSame(
            $instance,
            $instance->addEvent('onclick', "alert('test')"),
            'Should return a new instance when adding the attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->events(['onclick' => "alert('test')"]),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeEvent('onclick'),
            'Should return a new instance when removing the attribute, ensuring immutability.',
        );
    }

    /**
     * @param mixed[] $data
     * @param mixed[] $expected
     */
    #[DataProviderExternal(EventProvider::class, 'values')]
    public function testSetEventAttributeValue(array $data, array $expected, string $message): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $instance = $instance->events($data);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    /**
     * @phpstan-param string|\UnitEnum $key
     * @phpstan-param string|Stringable|null|Closure(): mixed $handler
     * @phpstan-param mixed[] $expected
     */
    #[DataProviderExternal(EventProvider::class, 'value')]
    public function testSetSingleEventAttributeValue(
        string|UnitEnum $key,
        string|Closure|Stringable|UnitEnum|null $handler,
        array $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $instance = $instance->addEvent($key, $handler);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    public function testThrowInvalidArgumentExceptionWhenEventAttributeValueIsInvalid(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::ATTRIBUTE_VALUE_MUST_BE_SCALAR_OR_CLOSURE->getMessage('object'),
        );

        $instance->events(['click' => new stdClass()]);
    }

    public function testThrowInvalidArgumentExceptionWhenRemoveEventAttributeKeyMissingOnPrefix(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::EVENT_KEY_MUST_START_WITH_ON->getMessage('invalid-key'),
        );

        $instance->removeEvent('invalid-key');
    }

    public function testThrowInvalidArgumentExceptionWhenRemoveEventAttributeWithEmptyKey(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(),
        );

        $instance->removeEvent('');
    }

    public function testThrowInvalidArgumentExceptionWhenSetEventAttributeKeyIsEmpty(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->events(['' => "alert('test')"]);
    }

    public function testThrowInvalidArgumentExceptionWhenSetEventAttributeKeyIsInvalid(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(1),
        );

        $instance->events([1 => "alert('test')"]);
    }

    public function testThrowInvalidArgumentExceptionWhenSetEventAttributeKeyMissingOnPrefix(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::EVENT_KEY_MUST_START_WITH_ON->getMessage('invalid-key'),
        );

        $instance->events(['invalid-key' => "alert('test')"]);
    }

    public function testThrowInvalidArgumentExceptionWhenSetSingleEventAttributeKeyMissingOnPrefix(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::EVENT_KEY_MUST_START_WITH_ON->getMessage('invalid-key'),
        );

        $instance->addEvent('invalid-key', "alert('test')");
    }

    public function testThrowInvalidArgumentExceptionWhenSetSingleEventAttributeWithEmptyKey(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->addEvent('', "alert('test')");
    }

    public function testThrowInvalidArgumentExceptionWhenSetSingleEventAttributeWithInvalidKey(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasEvents;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(2),
        );

        $instance->addEvent(Priority::HIGH, "alert('test')");
    }
}
