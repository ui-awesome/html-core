<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Tag;

use UIAwesome\Html\Core\Tag\Root;

use function sprintf;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\HtmlTest} class.
 *
 * Supplies comprehensive test data for validating root-level HTML tag normalization and enum integration, ensuring
 * standards-compliant output and robust type safety for tag rendering in element contexts.
 *
 * The test data covers real-world scenarios for root tag value propagation, supporting all enum cases and ensuring
 * consistent behavior across different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct normalization and propagation of root-level HTML tags.
 * - Named test data sets for precise failure identification.
 * - Validation of all enum cases for root tag rendering.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class RootProvider
{
    /**
     * Provides test cases for root tag scenarios.
     *
     * Supplies test data for validating root-level HTML tag normalization and enum integration.
     *
     * Each test case includes the input tag (UnitEnum) and the expected string value.
     *
     * @return array Test data for root tag scenarios.
     *
     * @phpstan-return array<string, array{Root, string}>
     */
    public static function rootTags(): array
    {
        $data = [];

        foreach (Root::cases() as $case) {
            $data[sprintf('%s root tag', $case->value)] = [$case, $case->value];
        }

        return $data;
    }
}
