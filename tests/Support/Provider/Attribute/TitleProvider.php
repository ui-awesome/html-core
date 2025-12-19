<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Attribute;

use PhpParser\Node\Scalar\String_;
use Stringable;
use UIAwesome\Html\Core\Tests\Support\Stub\Enum\Status;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Attribute\HasTitleTest} class.
 *
 * Supplies comprehensive test data for validating the handling of the global HTML `title` attribute in tag rendering,
 * ensuring standards-compliant assignment, override behavior, and value propagation according to the HTML
 * specification.
 *
 * The test data covers real-world scenarios for setting, overriding, and removing the `title` attribute, supporting
 * explicit string, UnitEnum for enum-based, and `null` for attribute removal, to maintain consistent output across
 * different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct propagation, assignment, and override of the `title` attribute in HTML element rendering.
 * - Named test data sets for precise failure identification.
 * - Validation of empty string, UnitEnum and `null` for the `title` attribute.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TitleProvider
{
    /**
     * Provides test cases for rendered HTML `title` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `title` attribute,
     * including empty string, UnitEnum, `null` and standard string.
     *
     * Each test case includes the input value, the initial attributes, the expected rendered output, and an assertion
     * message for clear identification.
     *
     * @return array Test data for rendered `title` attribute scenarios.
     *
     * @phpstan-return array<
     *   string,
     *   array{string|Stringable|UnitEnum|null, mixed[], string|Stringable|UnitEnum, string},
     * >
     */
    public static function renderAttribute(): array
    {
        return [
            'empty string' => [
                '',
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum' => [
                Status::ACTIVE,
                [],
                ' title="active"',
                'Should return the attribute value after setting it.',
            ],
            'enum replace existing' => [
                Status::INACTIVE,
                ['title' => 'active'],
                ' title="inactive"',
                "Should return new 'title' after replacing the existing 'title' attribute with enum value.",
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'inactive',
                ['title' => 'active'],
                ' title="inactive"',
                "Should return new 'title' after replacing the existing 'title' attribute.",
            ],
            'string' => [
                'active',
                [],
                ' title="active"',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                new class implements Stringable {
                    public function __toString(): string
                    {
                        return 'active';
                    }
                },
                [],
                ' title="active"',
                'Should return the attribute value after setting it with a Stringable instance.',
            ],
            'unset with null' => [
                null,
                ['title' => 'active'],
                '',
                "Should unset the 'title' attribute when 'null' is provided after a value.",
            ],
        ];
    }

    /**
     * Provides test cases for HTML `title` attribute scenarios.
     *
     * Supplies test data for validating assignment, override, and removal of the global HTML `title` attribute,
     * including empty string, UnitEnum, `null` and standard string.
     *
     * Each test case includes the input value, the initial attributes, the expected value, and an assertion message for
     * clear identification.
     *
     * @return array Test data for `title` attribute scenarios.
     *
     * @phpstan-return array<
     *   string,
     *   array{string|Stringable|UnitEnum|null, mixed[], string|Stringable|UnitEnum, string},
     * >
     */
    public static function values(): array
    {
        $stringable = new class implements Stringable {
            public function __toString(): string
            {
                return 'active';
            }
        };

        return [
            'empty string' => [
                '',
                [],
                '',
                'Should return an empty string when setting an empty string.',
            ],
            'enum' => [
                Status::ACTIVE,
                [],
                Status::ACTIVE,
                'Should return the attribute value after setting it.',
            ],
            'null' => [
                null,
                [],
                '',
                "Should return an empty string when the attribute is set to 'null'.",
            ],
            'replace existing' => [
                'inactive',
                ['title' => 'active'],
                'inactive',
                "Should return new 'title' after replacing the existing 'title' attribute.",
            ],
            'string' => [
                'active',
                [],
                'active',
                'Should return the attribute value after setting it.',
            ],
            'stringable' => [
                $stringable,
                [],
                $stringable,
                'Should return the attribute value after setting it with a Stringable instance.',
            ],
            'unset with null' => [
                null,
                ['title' => 'active'],
                '',
                "Should unset the 'title' attribute when 'null' is provided after a value.",
            ],
        ];
    }
}
