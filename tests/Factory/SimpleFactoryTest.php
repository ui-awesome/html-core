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
 *
 * Test coverage.
 * - Ensures instances are created with default property values when configuration is omitted.
 * - Sets public properties from configuration arrays during instance creation.
 * - Verifies Error is thrown when configuration targets non-public properties.
 * - Verifies LogicException is thrown when instantiating an abstract class.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('factory')]
final class SimpleFactoryTest extends TestCase
{
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
