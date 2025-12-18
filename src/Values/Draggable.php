<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Values;

/**
 * Represents standardized values for the HTML `draggable` global attribute.
 *
 * Provides a type-safe, standards-compliant set of draggable identifiers for use in element rendering, attributes, and
 * view helpers, ensuring technical consistency with the HTML specification and modern web standards.
 *
 * Key features.
 * - Designed for use in tags, components, and helpers requiring draggable assignment.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of draggable values for semantic markup generation and accessibility.
 * - Values follow the HTML specification for draggable: `false` and `true`.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/draggable
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Draggable: string
{
    /**
     * Indicates that the element is not draggable (`false`).
     *
     * The element cannot be dragged by the user.
     */
    case FALSE = 'false';

    /**
     * Indicates that the element is explicitly draggable (`true`).
     *
     * The element can be dragged by the user.
     */
    case TRUE = 'true';
}
