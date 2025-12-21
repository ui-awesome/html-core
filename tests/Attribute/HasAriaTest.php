<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use Closure;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use stdClass;
use Stringable;
use UIAwesome\Html\Core\Attribute\HasAria;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\AriaProvider;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\Priority;
use UIAwesome\Html\Helper\Attributes;
use UnitEnum;

#[Group('attributes')]
final class HasAriaTest extends TestCase
{
    /**
     * @param mixed[] $data
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(AriaProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithAriaAttribute(
        array $data,
        array $attributes,
        string $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasAria;
        };

        $instance = $instance->attributes($attributes)->ariaAttributes($data);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnNewInstanceWhenSettingAriaAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasAria;
        };

        self::assertNotSame(
            $instance,
            $instance->addAriaAttribute('pressed', true),
            'Should return a new instance when adding the attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->ariaAttributes(['pressed' => true]),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
        self::assertNotSame(
            $instance,
            $instance->removeAriaAttribute('pressed'),
            'Should return a new instance when removing the attribute, ensuring immutability.',
        );
    }

    /**
     * @param mixed[] $data
     * @param mixed[] $expected
     */
    #[DataProviderExternal(AriaProvider::class, 'values')]
    public function testSetAriaAttributeValue(array $data, array $expected, string $message): void
    {
        $instance = new class {
            use HasAttributes;
            use HasAria;
        };

        $instance = $instance->ariaAttributes($data);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    /**
     * @phpstan-param scalar|Stringable|UnitEnum|null|Closure(): mixed $value
     * @phpstan-param mixed[] $expected
     */
    #[DataProviderExternal(AriaProvider::class, 'value')]
    public function testSetSingleAriaAttributeValue(
        string|UnitEnum $key,
        bool|float|int|string|Closure|Stringable|UnitEnum|null $value,
        array $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasAria;
        };

        $instance = $instance->addAriaAttribute($key, $value);

        self::assertSame(
            $expected,
            $instance->getAttributes(),
            $message,
        );
    }

    public function testThrowInvalidArgumentExceptionWhenAriaAttributeValueIsInvalid(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasAria;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::ATTRIBUTE_VALUE_MUST_BE_SCALAR_OR_CLOSURE->getMessage('object'),
        );

        $instance->ariaAttributes(['key' => new stdClass()]);
    }

    public function testThrowInvalidArgumentExceptionWhenSetAriaAttributeKeyIsEmpty(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasAria;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->ariaAttributes(['' => 'value']);
    }

    public function testThrowInvalidArgumentExceptionWhenSetAriaAttributeKeyIsInvalid(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasAria;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(1),
        );

        $instance->ariaAttributes([1 => '']);
    }

    public function testThrowInvalidArgumentExceptionWhenSetSingleAriaAttributeWithEmptyKey(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasAria;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(''),
        );

        $instance->addAriaAttribute('', 'value');
    }

    public function testThrowInvalidArgumentExceptionWhenSetSingleAriaAttributeWithInvalidKey(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasAria;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::KEY_MUST_BE_NON_EMPTY_STRING->getMessage(2),
        );

        $instance->addAriaAttribute(Priority::HIGH, 'value');
    }
}
