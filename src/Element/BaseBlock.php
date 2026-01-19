<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

use UIAwesome\Html\Attribute\Global\{
    CanBeAutofocus,
    CanBeHidden,
    HasAccesskey,
    HasAria,
    HasClass,
    HasContentEditable,
    HasData,
    HasDir,
    HasDraggable,
    HasEvents,
    HasId,
    HasLang,
    HasMicroData,
    HasRole,
    HasSpellcheck,
    HasStyle,
    HasTabindex,
    HasTitle,
    HasTranslate,
};
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Interop\BlockInterface;
use UIAwesome\Html\Mixin\{HasAttributes, HasContent};

use function preg_replace;

/**
 * Base class for constructing block-level HTML elements.
 *
 * Provides the shared implementation for block-level tags rendered through {@see Html}. Subclasses supply the tag via
 * {@see BaseBlock::getTag()}, while attributes and content are managed via mixins.
 *
 * Intended for tag classes that need block-level rendering with optional `begin()`/`end()` usage.
 *
 * Key features.
 * - Mixes in global attribute traits and attribute/content storage.
 * - Normalizes output by collapsing consecutive blank lines.
 * - Renders a full element via {@see Html::element()} when not in `begin()`/`end()` mode.
 * - Requires subclasses to provide a {@see BlockInterface} tag.
 * - Supports `begin()`/`end()` rendering via {@see Html::begin()} and {@see Html::end()}.
 *
 * {@see BlockInterface} for contract details.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseBlock extends BaseTag
{
    use CanBeAutofocus;
    use CanBeHidden;
    use HasAccesskey;
    use HasAria;
    use HasAttributes;
    use HasClass;
    use HasContent;
    use HasContentEditable;
    use HasData;
    use HasDir;
    use HasDraggable;
    use HasEvents;
    use HasId;
    use HasLang;
    use HasMicroData;
    use HasRole;
    use HasSpellcheck;
    use HasStyle;
    use HasTabindex;
    use HasTitle;
    use HasTranslate;

    /**
     * Returns the tag instance representing the block element.
     *
     * Must be implemented by subclasses to specify the concrete block tag.
     *
     * @return BlockInterface Tag instance for the block element.
     *
     * Usage example:
     * ```php
     * public function getTag(): BlockInterface
     * {
     *    return Block::DIV;
     * }
     * ```
     */
    abstract protected function getTag(): BlockInterface;

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
            return Html::element($this->getTag(), $this->getContent(), $this->getAttributes());
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
        return Html::begin($this->getTag(), $this->getAttributes());
    }
}
