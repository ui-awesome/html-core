<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core;

/**
 * Provides a robust, type-safe API for advanced HTML tag rendering and element generation.
 *
 * Enables standards-compliant, immutable, and extensible creation, rendering, and management of HTML tags and elements
 * for modern web applications.
 *
 * Designed for use in HTML helpers, tag builders, and view renderers, this class ensures secure and flexible HTML
 * output, integrating with attribute and encoding helpers for safe and predictable results.
 *
 * Key features.
 * - Exception-driven error handling for invalid tag usage.
 * - Integration with attribute and encoding helpers for secure output.
 * - Standards-compliant rendering of block, inline, list, root, table, and void elements.
 * - Supports `UnitEnum` tag types for flexible API design.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Void_element
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#main_root
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#table_content
 * {@see Base\BaseHtml} for the base implementation.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class Html extends Base\BaseHtml {}
