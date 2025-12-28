<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tag;

/**
 * Represents table-related HTML elements according to the HTML standard specification.
 *
 * Provides a type-safe, standards-compliant set of table element tag names for use in element rendering, tags and view
 * helpers.
 *
 * Each case corresponds to a valid table HTML tag as defined by the W3C and MDN documentation.
 *
 * Key features.
 * - Designed for use in view, tags and components requiring table element structure.
 * - Ensures technical consistency with the HTML specification and modern web standards.
 * - Implement of {@see BlockInterface} for contract adherence.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of table HTML tags for semantic markup generation.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#table_content
 * {@see BlockInterface} for contract details.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Table: string implements BlockInterface
{
    /**
     * Case for the `<caption>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/caption
     */
    case CAPTION = 'caption';

    /**
     * Case for the `<colgroup>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/colgroup
     */
    case COLGROUP = 'colgroup';
    /**
     * Case for the `<table>` HTML tag.
     *
     * Categorized as flow, and palpable content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/table
     */
    case TABLE = 'table';

    /**
     * Case for the `<tbody>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/tbody
     */
    case TBODY = 'tbody';

    /**
     * Case for the `<td>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/td
     */
    case TD = 'td';

    /**
     * Case for the `<tfoot>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/tfoot
     */
    case TFOOT = 'tfoot';

    /**
     * Case for the `<th>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/th
     */
    case TH = 'th';

    /**
     * Case for the `<thead>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/thead
     */
    case THEAD = 'thead';

    /**
     * Case for the `<tr>` HTML tag.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/tr
     */
    case TR = 'tr';
}
