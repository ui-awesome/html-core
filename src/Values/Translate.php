<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Values;

/**
 * Represents standardized values for the HTML `translate` global attribute.
 *
 * Provides a type-safe, standards-compliant set of translate identifiers for use in element rendering, attributes, and
 * view helpers, ensuring technical consistency with the HTML specification and modern web standards.
 *
 * Key features.
 * - Designed for use in tags, components, and helpers requiring translate assignment.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of translate values for semantic markup generation and accessibility.
 * - Values follow the HTML specification for translate: `no` and `yes`.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/translate
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Translate: string
{
    /**
     * Indicates that the element is not translatable (`no`).
     *
     * The element cannot be translated by the user.
     */
    case NO = 'no';

    /**
     * Indicates that the element is explicitly translatable (`yes`).
     *
     * The element can be translated by the user.
     */
    case YES = 'yes';
}
