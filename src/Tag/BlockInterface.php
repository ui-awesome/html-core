<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tag;

use BackedEnum;

/**
 * Defines a contract for block-level HTML tag enums.
 *
 * Enables type-safe, standards-compliant representation of block-level HTML elements for advanced tag rendering and
 * element generation in modern web applications.
 *
 * Designed for use in tag builders, view renderers, and HTML helpers, this interface ensures robust and extensible
 * handling of block-level content, integrating with attribute and encoding helpers for secure and predictable output.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 * {@see BackedEnum} for enum base implementation.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
interface BlockInterface extends BackedEnum {}
