<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Factory;

use Error;
use LogicException;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tests\Support\Stub\TagInline;

/**
 * Test suite for {@see SimpleFactory} functionality and behavior.
 *
 * Validates the instantiation and configuration management of tag elements using the {@see SimpleFactory} according to
 * the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of tag creation, supporting default configuration properties
 * and exception handling for abstract class instantiation and non-public property assignments.
 *
 * Test coverage.
 * - Accurate creation of tag instances with default configuration property values.
 * - Exception handling when attempting to instantiate abstract classes and setting non-public properties.
 * - Validation of property assignment and immutability of the factory API.
 *
 * {@see BaseTag} for abstract tag base class.
 * {@see Message} for exception message enumeration.
 * {@see TagInline} for stub implementation details.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class SimpleFactoryTest extends TestCase
{
    public function testCreateWithDefaultConfigurationPropertiesValues(): void
    {
        $tag = TagInline::tag(['flag' => true]);

        self::assertTrue(
            $tag->flag,
            'Failed asserting that factory creates instance with default configuration properties values.',
        );
    }

    public function testCreateWithoutConfigurationUsesDefaultValues(): void
    {
        $tag = TagInline::tag();

        self::assertFalse(
            $tag->flag,
            'Failed asserting that factory creates instance with default property values.',
        );
    }

    public function testThrowExceptionWhenInstantiateAbstractClass(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            Message::CANNOT_INSTANTIATE_ABSTRACT_CLASS->getMessage(BaseTag::class),
        );

        SimpleFactory::create(BaseTag::class);
    }

    public function testThrowExceptionWhenSetNotPublicProperty(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage(
            'Cannot access private property UIAwesome\Html\Core\Tests\Support\Stub\TagInline::$flagDisabled',
        );

        TagInline::tag(['flagDisabled' => true]);
    }
}
