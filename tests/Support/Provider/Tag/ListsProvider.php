<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Provider\Tag;

use UIAwesome\Html\Core\Tests\Support\EnumDataGenerator;
use UIAwesome\Html\Interop\Lists;
use UnitEnum;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\HtmlTest} class.
 *
 * Supplies comprehensive test data for validating list-level HTML tag normalization and enum integration, ensuring
 * standards-compliant output and robust type safety for tag rendering in element contexts.
 *
 * The test data covers real-world scenarios for list tag value propagation, supporting all enum cases and ensuring
 * consistent behavior across different rendering configurations.
 *
 * The provider organizes test cases with descriptive names for clear identification of failure cases during test
 * execution and debugging sessions.
 *
 * Key features.
 * - Ensures correct normalization and propagation of list-level HTML tags.
 * - Named test data sets for precise failure identification.
 * - Validation of all enum cases for list tag rendering.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class ListsProvider
{
    /**
     * Provides test cases for list tag scenarios.
     *
     * Supplies test data for validating list-level HTML tag normalization and enum integration.
     *
     * Each test case includes the input tag (UnitEnum) and the expected string value.
     *
     * @return array Test data for list tag scenarios.
     *
     * @phpstan-return array<string, array{UnitEnum, string}>
     */
    public static function listTags(): array
    {
        return EnumDataGenerator::tagCases(Lists::class, 'list');
    }
}
