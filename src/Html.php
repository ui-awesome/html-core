<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core;

use UIAwesome\Html\Core\Base\BaseHtml;

/**
 * Facade for HTML tag rendering helpers.
 *
 * Exposes the static rendering API from {@see Base\BaseHtml} under a concise class name.
 *
 * Intended for call sites that render tags using backed-enum tag values and attribute arrays.
 *
 * Key features.
 * - Formats block element output with line breaks consistent with {@see Base\BaseHtml}.
 * - Provides `begin()`, `end()`, `inline()`, `void()`, and `element()` helpers.
 * - Renders attributes and optionally encodes content via the base implementation.
 * - Supports block, inline, and void tag types through the corresponding interop contracts.
 *
 * {@see BaseHtml} for the base implementation.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Void_element
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#main_root
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#table_content
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class Html extends BaseHtml {}
