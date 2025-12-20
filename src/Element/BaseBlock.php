<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

use UIAwesome\Html\Core\Attribute\{
    CanBeAutofocus,
    CanBeHidden,
    HasAccesskey,
    HasClass,
    HasContentEditable,
    HasData,
    HasDir,
    HasDraggable,
    HasId,
    HasLang,
    HasMicroData,
    HasSpellcheck,
    HasStyle,
    HasTabindex,
    HasTitle,
};
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Mixin\{HasAttributes, HasContent};
use UIAwesome\Html\Core\Tag\{Block, Lists, Root, Table};

use function preg_replace;

/**
 * Base class for constructing HTML block-level elements according to the HTML specification.
 *
 * Provides a standards-compliant, extensible foundation for block tag rendering, supporting global HTML attributes,
 * content management, and attribute immutability.
 *
 * Intended for use in components and tags that require dynamic or programmatic manipulation of block-level HTML
 * elements, supporting advanced rendering scenarios and consistent API design.
 *
 * Key features.
 * - Enforces standards-compliant handling of block tags as defined by the HTML specification.
 * - Immutable API for attribute and content assignment.
 * - Implements the core logic for block-level tag construction.
 * - Integrates global HTML attribute management via traits.
 * - Supports extensibility for custom block element implementations.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 * {@see Block} for valid block-level tags.
 * {@see Lists} for valid list-level tags.
 * {@see Root} for valid root-level tags.
 * {@see Table} for valid table-level tags.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseBlock extends BaseTag
{
    use CanBeAutofocus;
    use CanBeHidden;
    use HasAccesskey;
    use HasAttributes;
    use HasClass;
    use HasContent;
    use HasContentEditable;
    use HasData;
    use HasDir;
    use HasDraggable;
    use HasId;
    use HasLang;
    use HasMicroData;
    use HasSpellcheck;
    use HasStyle;
    use HasTabindex;
    use HasTitle;

    /**
     * Returns the tag instance representing the block element.
     *
     * Must be implemented by subclasses to specify the concrete block tag.
     *
     * @return Block|Lists|Root|Table Tag instance for the block element.
     *
     * Usage example:
     * ```php
     * public function getTag(): Block|Lists|Root|Table
     * {
     *    return Block::DIV;
     * }
     * ```
     */
    abstract protected function getTag(): Block|Lists|Root|Table;

    /**
     * Cleans up the output after rendering the block element.
     *
     * Removes excessive consecutive newlines from the rendered output to ensure clean HTML structure.
     *
     * @param string $result Rendered HTML output.
     *
     * @return string Cleaned HTML output with excessive newlines removed.
     */
    protected function afterRun(string $result): string
    {
        $normalizeOutput = preg_replace("/\n{2,}/", "\n", $result) ?? '';

        return parent::afterRun($normalizeOutput);
    }

    /**
     * Renders the block element.
     *
     * If the begin tag was not executed, renders the complete tag with content and attributes, otherwise returns the
     * closing tag for the block element.
     *
     * @return string Rendered HTML for the block element.
     */
    protected function run(): string
    {
        if ($this->isBeginExecuted() === false) {
            return Html::element($this->getTag(), $this->getContent(), $this->attributes);
        }

        return Html::end($this->getTag());
    }

    /**
     * Begins rendering the block element.
     *
     * Calls the parent begin method and returns the opening tag for the block element with the current attributes.
     *
     * @return string Opening HTML tag for the block element.
     *
     * Usage example:
     * ```php
     * <?= $block->begin() ?>
     * // Output: <div class="example-class" id="example-id">
     * ```
     */
    protected function runBegin(): string
    {
        return Html::begin($this->getTag(), $this->attributes);
    }
}
