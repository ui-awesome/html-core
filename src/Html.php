<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core;

use UIAwesome\Html\Core\Base\BaseHtml;

/**
 * Provides a implementation for static methods to generate HTML elements.
 *
 * Usage example:
 * ```php
 * echo \UIAwesome\Html\Core\Html::inline(
 *     \UIAwesome\Html\Interop\Inline::SPAN,
 *     'Hello',
 *     ['class' => 'label'],
 * );
 * ```
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
