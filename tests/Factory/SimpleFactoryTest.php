<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Factory;

use Error;
use LogicException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tests\Support\Stub\TagInline;

/**
 * Unit tests for the {@see SimpleFactory} class.
 */
#[Group('factory')]
final class SimpleFactoryTest extends TestCase
{
    public function testConfigureIgnoresNumericKeys(): void
    {
        $tag = SimpleFactory::configure(TagInline::tag(), [null, 'flag' => true]);

        self::assertInstanceOf(
            TagInline::class,
            $tag,
            'Failed asserting that configuration preserves the tag type.',
        );
        self::assertTrue(
            $tag->flag,
            'Failed asserting that numeric cookbook keys are ignored while valid string keys are applied.',
        );
    }

    public function testCreateWithDefaultConfigurationPropertiesValues(): void
    {
        self::assertTrue(
            TagInline::tag(['flag' => true])->flag,
            'Failed asserting that factory creates instance with default configuration properties values.',
        );
    }

    public function testCreateWithoutConfigurationUsesDefaultValues(): void
    {
        self::assertFalse(
            TagInline::tag()->flag,
            'Failed asserting that factory creates instance with default property values.',
        );
    }

    public function testThrowErrorForSetNotPublicProperty(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage(
            'Cannot access private property UIAwesome\Html\Core\Tests\Support\Stub\TagInline::$flagDisabled',
        );

        TagInline::tag(['flagDisabled' => true]);
    }

    public function testThrowLogicExceptionForInstantiateAbstractClass(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            Message::CANNOT_INSTANTIATE_ABSTRACT_CLASS->getMessage(BaseTag::class),
        );

        SimpleFactory::create(BaseTag::class);
    }
}
