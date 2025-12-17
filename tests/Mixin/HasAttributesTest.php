<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Mixin;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Mixin\HasAttributes;

/**
 * Test suite for {@see HasAttributes} mixin functionality and behavior.
 *
 * Validates the management and immutability of HTML attribute handling in tag rendering, according to the HTML Living
 * Standard specification.
 *
 * Ensures correct initialization, assignment, and retrieval of attributes, supporting array-based attribute storage and
 * enforcing immutability when setting new attributes.
 *
 * Test coverage.
 * - Accurate retrieval of attributes when not set.
 * - Correct assignment and retrieval of attribute value.
 * - Immutability of the mixin when setting attributes.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('mixin')]
final class HasAttributesTest extends TestCase
{
    public function testReturnEmptyArrayWhenAttributesNotSet(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertSame(
            [],
            $instance->getAttributes(),
            'Should return an empty array when no attributes are set.',
        );
    }

    public function testReturnNewInstanceWhenSettingAttributes(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        self::assertNotSame(
            $instance,
            $instance->attributes([]),
            'Should return a new instance when setting the attributes, ensuring immutability.',
        );
    }

    public function testSetAttributesValue(): void
    {
        $instance = new class {
            use HasAttributes;
        };

        $instance = $instance->attributes(['class' => 'value']);
        $instance = $instance->attributes(['disabled' => true]);

        self::assertSame(
            ['class' => 'value', 'disabled' => true],
            $instance->getAttributes(),
            'Should return the attributes value after setting it.',
        );
    }
}
