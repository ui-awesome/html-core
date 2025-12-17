<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Values;

/**
 * Represents standardized values for the HTML `contenteditable` global attribute.
 *
 * Provides a type-safe, standards-compliant set of contenteditable identifiers for use in element rendering,
 * attributes, and view helpers, ensuring technical consistency with the HTML specification and modern web standards.
 *
 * Key features.
 * - Designed for use in tags, components, and helpers requiring contenteditable assignment.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of contenteditable values for semantic markup generation and accessibility.
 * - Values follow the HTML specification for contenteditable: `true`, `false`, and `plaintext-only`.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/contenteditable
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum ContentEditable: string
{
    /**
     * Indicates that the element is not editable (`false`).
     *
     * Element's contents cannot be modified by the user.
     */
    case FALSE = 'false';

    /**
     * Indicates that the element is editable as plain text only (`plaintext-only`).
     *
     * Only plain text editing is allowed; no rich text formatting is permitted.
     */
    case PLAINTEXT_ONLY = 'plaintext-only';

    /**
     * Indicates that the element is editable (`true`).
     *
     * Element's contents can be modified by the user, including rich text formatting.
     */
    case TRUE = 'true';
}
