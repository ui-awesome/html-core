<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Tag;

use UIAwesome\Html\Core\Tag\Block;

use function sprintf;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\HtmlTest} class.
 *
 * Supplies comprehensive test data for validating block-level HTML tag normalization and enum integration, ensuring
 * standards-compliant output and robust type safety for tag rendering in element contexts.
 *
 * The test data covers real-world scenarios for block tag value propagation, supporting all enum cases and ensuring
 * consistent behavior across different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct normalization and propagation of block-level HTML tags.
 * - Named test data sets for precise failure identification.
 * - Validation of all enum cases for block tag rendering.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class BlockProvider
{
    /**
     * Provides test cases for block tag scenarios.
     *
     * Supplies test data for validating block-level HTML tag normalization and enum integration.
     *
     * Each test case includes the input tag (UnitEnum) and the expected string value.
     *
     * @return array Test data for block tag scenarios.
     *
     * @phpstan-return array<string, array{Block, string}>
     */
    public static function blockTags(): array
    {
        $data = [];

        foreach (Block::cases() as $case) {
            $data[sprintf('%s block tag', $case->value)] = [$case, $case->value];
        }

        return $data;
    }
}
