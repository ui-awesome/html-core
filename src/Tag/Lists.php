<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tag;

/**
 * Represents list-related HTML elements according to the HTML standard specification.
 *
 * Provides a type-safe, standards-compliant set of list element tag names for use in element rendering, tags and view
 * helpers.
 *
 * Each case corresponds to a valid list HTML tag as defined by the W3C and MDN documentation.
 *
 * Key features.
 * - Designed for use in view, tags and components requiring list element structure.
 * - Ensures technical consistency with the HTML specification and modern web standards.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of list HTML tags for semantic markup generation.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#text_content
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Lists: string
{
    /**
     * Case for the `<dd>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dd
     */
    case DD = 'dd';

    /**
     * Case for the `<dl>` HTML tag.
     *
     * Categorized as flow and palpable content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dl
     */
    case DL = 'dl';

    /**
     * Case for the `<dt>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dt
     */
    case DT = 'dt';

    /**
     * Case for the `<li>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/li
     */
    case LI = 'li';

    /**
     * Case for the `<ol>` HTML tag.
     *
     * Categorized as flow and palpable content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/ol
     */
    case OL = 'ol';

    /**
     * Case for the `<ul>` HTML tag.
     *
     * Categorized as flow and palpable content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/ul
     */
    case UL = 'ul';
}
