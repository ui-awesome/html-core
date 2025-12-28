<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tag;

/**
 * Represents root-level HTML elements according to the HTML standard specification.
 *
 * Provides a type-safe, standards-compliant set of root-level tag names for use in element rendering, tags and view
 * helpers.
 *
 * Each case corresponds to a valid root-level HTML tag as defined by the W3C and MDN documentation.
 *
 * Key features.
 * - Designed for use in view, tags and components requiring root element structure.
 * - Ensures technical consistency with the HTML specification and modern web standards.
 * - Implement of {@see BlockInterface} for contract adherence.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of root HTML tags for semantic markup generation.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements#main_root
 * {@see BlockInterface} for contract details.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Root: string implements BlockInterface
{
    /**
     * Case for the `<body>` HTML tag.
     *
     * Represents the content of an HTML document.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/body
     */
    case BODY = 'body';

    /**
     * Case for the `<head>` HTML tag.
     *
     * Contains machine-readable information (metadata) about the document.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/head
     */
    case HEAD = 'head';
    /**
     * Case for the `<html>` HTML tag.
     *
     * Represents the root (top-level element) of an HTML document.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/html
     */
    case HTML = 'html';
}
