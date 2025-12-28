<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tag;

/**
 * Represents inline-level HTML elements according to the HTML standard specification.
 *
 * Provides a type-safe, standards-compliant set of inline-level tag names for use in element rendering, tags and view
 * helpers.
 *
 * Each case corresponds to a valid inline-level HTML tag as defined by the W3C and MDN documentation.
 *
 * Key features.
 * - Designed for use in view, tags and components requiring inline-level content structure.
 * - Ensures technical consistency with the HTML specification and modern web standards.
 * - Implementation of {@see InlineInterface} for contract adherence.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of inline-level HTML tags for semantic markup generation.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 * {@see InlineInterface} for contract details.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Inline: string implements InlineInterface
{
    /**
     * Case for the `<a>` HTML tag.
     *
     * Categorized as flow, interactive, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/a
     */
    case A = 'a';

    /**
     * Case for the `<abbr>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/abbr
     */
    case ABBR = 'abbr';

    /**
     * Case for the `<b>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/b
     */
    case B = 'b';

    /**
     * Case for the `<bdi>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/bdi
     */
    case BDI = 'bdi';

    /**
     * Case for the `<bdo>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/bdo
     */
    case BDO = 'bdo';

    /**
     * Case for the `<button>` HTML tag.
     *
     * Categorized as flow, form-associated, interactive, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/button
     */
    case BUTTON = 'button';

    /**
     * Case for the `<cite>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/cite
     */
    case CITE = 'cite';

    /**
     * Case for the `<code>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/code
     */
    case CODE = 'code';

    /**
     * Case for the `<data>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/data
     */
    case DATA = 'data';

    /**
     * Case for the `<dfn>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/dfn
     */
    case DFN = 'dfn';

    /**
     * Case for the `<em>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/em
     */
    case EM = 'em';

    /**
     * Case for the `<i>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/i
     */
    case I = 'i';

    /**
     * Case for the `<kbd>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/kbd
     */
    case KBD = 'kbd';

    /**
     * Case for the `<label>` HTML tag.
     *
     * Categorized as flow, form-associated, interactive, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/label
     */
    case LABEL = 'label';

    /**
     * Case for the `<map>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/map
     */
    case MAP = 'map';

    /**
     * Case for the `<mark>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/mark
     */
    case MARK = 'mark';

    /**
     * Case for the `<meter>` HTML tag.
     *
     * Categorized as flow, form-associated, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/meter
     */
    case METER = 'meter';

    /**
     * Case for the `<output>` HTML tag.
     *
     * Categorized as flow, form-associated, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/output
     */
    case OUTPUT = 'output';

    /**
     * Case for the `<picture>` HTML tag.
     *
     * Categorized as embedded, flow, and palpable content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/picture
     */
    case PICTURE = 'picture';

    /**
     * Case for the `<progress>` HTML tag.
     *
     * Categorized as flow, form-associated, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/progress
     */
    case PROGRESS = 'progress';

    /**
     * Case for the `<q>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/q
     */
    case Q = 'q';

    /**
     * Case for the `<rp>` HTML tag.
     *
     * Categorized as phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/rp
     */
    case RP = 'rp';

    /**
     * Case for the `<rt>` HTML tag.
     *
     * Categorized as phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/rt
     */
    case RT = 'rt';

    /**
     * Case for the `<ruby>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/ruby
     */
    case RUBY = 'ruby';

    /**
     * Case for the `<s>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/s
     */
    case S = 's';

    /**
     * Case for the `<samp>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/samp
     */
    case SAMP = 'samp';

    /**
     * Case for the `<small>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/small
     */
    case SMALL = 'small';

    /**
     * Case for the `<span>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/span
     */
    case SPAN = 'span';

    /**
     * Case for the `<strong>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/strong
     */
    case STRONG = 'strong';

    /**
     * Case for the `<sub>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/sub
     */
    case SUB = 'sub';

    /**
     * Case for the `<sup>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/sup
     */
    case SUP = 'sup';

    /**
     * Case for the `<time>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/time
     */
    case TIME = 'time';

    /**
     * Case for the `<u>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/u
     */
    case U = 'u';

    /**
     * Case for the `<var>` HTML tag.
     *
     * Categorized as flow, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/var
     */
    case VAR = 'var';
}
