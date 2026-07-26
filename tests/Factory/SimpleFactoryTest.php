<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Factory;

use Error;
use LogicException;
use PHPUnit\Framework\Attributes\{Group, RequiresPhp};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Exception\{ConfigException, Message};
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

    public function testConfigureSkipsKeysMatchingNoMember(): void
    {
        self::assertTrue(
            TagInline::tag(['undefinedMember' => true, 'flag' => true])->flag,
            'Unknown keys must be skipped without interrupting the remaining configuration.',
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

    public function testThrowConfigExceptionWhenSettingNotPublicProperty(): void
    {
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_PROPERTY_MUST_BE_PUBLIC->getMessage(TagInline::class, 'flagDisabled'),
        );

        TagInline::tag(['flagDisabled' => true]);
    }

    #[RequiresPhp('>= 8.4.0')]
    public function testThrowConfigExceptionWhenSettingPropertyWithAsymmetricVisibility(): void
    {
        /**
         * Defined through `eval()` so that runtimes, static analysis, and coding standards below PHP 8.4 never parse
         * the asymmetric visibility syntax.
         *
         * @phpstan-var BaseTag
         */
        $tag = eval(<<<'PHP'
            return new class extends \UIAwesome\Html\Core\Base\BaseTag {
                public private(set) bool $flagRestricted = false;

                protected function run(): string
                {
                    return '';
                }
            };
            PHP);

        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_PROPERTY_MUST_BE_WRITABLE->getMessage($tag::class, 'flagRestricted'),
        );

        SimpleFactory::configure($tag, ['flagRestricted' => true]);
    }

    public function testThrowConfigExceptionWhenSettingReadonlyProperty(): void
    {
        try {
            TagInline::tag(['flagLocked' => true]);

            self::fail('Readonly property write must be rejected.');
        } catch (ConfigException $exception) {
            self::assertSame(
                Message::CONFIG_PROPERTY_MUST_BE_WRITABLE->getMessage(TagInline::class, 'flagLocked'),
                $exception->getMessage(),
                'Message must name the rejected property.',
            );
            self::assertInstanceOf(
                Error::class,
                $exception->getPrevious(),
                'Original `Error` must be preserved.',
            );
        }
    }

    public function testThrowConfigExceptionWhenSettingStaticProperty(): void
    {
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_PROPERTY_MUST_BE_PUBLIC->getMessage(TagInline::class, 'flagShared'),
        );

        TagInline::tag(['flagShared' => true]);
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
