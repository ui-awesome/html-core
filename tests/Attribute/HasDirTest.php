<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Attribute;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\{DataProviderExternal, Group};
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Attribute\HasDir;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tests\Support\Provider\Attribute\DirProvider;
use UIAwesome\Html\Core\Values\Direction;
use UIAwesome\Html\Helper\{Attributes, Enum};
use UnitEnum;

/**
 * Test suite for {@see HasDir} trait functionality and behavior.
 *
 * Validates the management of the global HTML `dir` attribute according to the HTML Living Standard specification.
 *
 * Ensures correct handling, immutability, and validation of the `dir` attribute in tag rendering, supporting string,
 * UnitEnum, and `null` for dynamic direction assignment.
 *
 * Test coverage:
 * - Accurate rendering of attributes with the `dir` attribute.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the trait's API when setting or overriding the `dir` attribute.
 * - Proper assignment and overriding of `dir` value.
 *
 * {@see DirProvider} for test case data providers.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('attributes')]
final class HasDirTest extends TestCase
{
    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(DirProvider::class, 'renderAttribute')]
    public function testRenderAttributesWithDirectionAttribute(
        string|UnitEnum|null $dir,
        array $attributes,
        string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasDir;
        };

        $instance = $instance->attributes($attributes)->dir($dir);

        self::assertSame(
            $expected,
            Attributes::render($instance->getAttributes()),
            $message,
        );
    }

    public function testReturnEmptyWhenDirAttributeNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasDir;
        };

        self::assertEmpty(
            $instance->getAttributes(),
            'Should have no attributes set when no attribute is provided.',
        );
    }

    public function testReturnNewInstanceWhenSettingDirAttribute(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasDir;
        };

        self::assertNotSame(
            $instance,
            $instance->dir(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    /**
     * @phpstan-param mixed[] $attributes
     */
    #[DataProviderExternal(DirProvider::class, 'values')]
    public function testSetDirAttributeValue(
        string|UnitEnum|null $dir,
        array $attributes,
        string|UnitEnum $expected,
        string $message,
    ): void {
        $instance = new class {
            use HasAttributes;
            use HasDir;
        };

        $instance = $instance->attributes($attributes)->dir($dir);

        self::assertSame(
            $expected,
            $instance->getAttributes()['dir'] ?? '',
            $message,
        );
    }

    public function testThrowExceptionWhenSettingInvalidDirValue(): void
    {
        $instance = new class {
            use HasAttributes;
            use HasDir;
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                'dir',
                implode('\', \'', Enum::normalizeArray(Direction::cases())),
            ),
        );

        $instance->dir('invalid-value');
    }
}
