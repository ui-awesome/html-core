<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tag;

/**
 * Represents void (self-closing) HTML elements according to the HTML standard specification.
 *
 * Provides a type-safe, standards-compliant set of void element tag names for use in element rendering, tags and view
 * helpers.
 *
 * Each case corresponds to a valid void HTML tag as defined by the W3C and MDN documentation.
 *
 * Key features.
 * - Designed for use in view, tags and components requiring void element structure.
 * - Ensures technical consistency with the HTML specification and modern web standards.
 * - Implement of {@see VoidInterface} for contract adherence.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of void HTML tags for semantic markup generation.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Void_element
 * {@see VoidInterface} for contract details.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Voids: string implements VoidInterface
{
    /**
     * Case for the `<area>` HTML tag.
     *
     * Categorized as flow, phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/area
     */
    case AREA = 'area';

    /**
     * Case for the `<base>` HTML tag.
     *
     * Categorized as metadata content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/base
     */
    case BASE = 'base';

    /**
     * Case for the `<br>` HTML tag.
     *
     * Categorized as flow, palpable, phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/br
     */
    case BR = 'br';

    /**
     * Case for the `<col>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/col
     */
    case COL = 'col';

    /**
     * Case for the `<embed>` HTML tag.
     *
     * Categorized as flow, embedded, interactive, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/embed
     */
    case EMBED = 'embed';

    /**
     * Case for the `<hr>` HTML tag.
     *
     * Categorized as flow content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/hr
     */
    case HR = 'hr';

    /**
     * Case for the `<img>` HTML tag.
     *
     * Categorized as flow, embedded, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/img
     */
    case IMG = 'img';

    /**
     * Case for the `<input>` HTML tag.
     *
     * Categorized as flow, form-associated, interactive, palpable, and phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/input
     */
    case INPUT = 'input';

    /**
     * Case for the `<link>` HTML tag.
     *
     * Categorized as metadata content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/link
     */
    case LINK = 'link';

    /**
     * Case for the `<meta>` HTML tag.
     *
     * Categorized as metadata content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/meta
     */
    case META = 'meta';

    /**
     * Case for the `<source>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/source
     */
    case SOURCE = 'source';

    /**
     * Case for the `<track>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/track
     */
    case TRACK = 'track';

    /**
     * Case for the `<wbr>` HTML tag.
     *
     * Categorized as flow, phrasing content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/wbr
     */
    case WBR = 'wbr';
}
