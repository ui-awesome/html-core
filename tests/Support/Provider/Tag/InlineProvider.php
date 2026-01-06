<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Tag;

use UIAwesome\Html\Core\Tests\Support\EnumDataGenerator;
use UIAwesome\Html\Interop\Inline;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\HtmlTest} class.
 *
 * Supplies comprehensive test data for validating inline-level HTML tag normalization and enum integration, ensuring
 * standards-compliant output and robust type safety for tag rendering in element contexts.
 *
 * The test data covers real-world scenarios for inline tag value propagation, supporting all enum cases and ensuring
 * consistent behavior across different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct normalization and propagation of inline-level HTML tags.
 * - Named test data sets for precise failure identification.
 * - Validation of all enum cases for inline tag rendering.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class InlineProvider
{
    /**
     * Provides test cases for inline tag scenarios.
     *
     * Supplies test data for validating inline-level HTML tag normalization and enum integration.
     *
     * Each test case includes the input tag (UnitEnum) and the expected string value.
     *
     * @return array Test data for inline tag scenarios.
     *
     * @phpstan-return array<string, array{UnitEnum, string}>
     */
    public static function inlineTags(): array
    {
        return EnumDataGenerator::tagCases(Inline::class, 'inline');
    }
}
