<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core;

use UIAwesome\Html\Core\Base\BaseHtml;

/**
 * Provides an implementation for static methods to generate HTML elements.
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
 * @see https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 * @see https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 * @see https://developer.mozilla.org/en-US/docs/Glossary/Void_element
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#main_root
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#table_content
 */
final class Html extends BaseHtml {}
