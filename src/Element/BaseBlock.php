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
use UIAwesome\Html\Helper\LineBreakNormalizer;
use UIAwesome\Html\Interop\BlockInterface;
use UIAwesome\Html\Mixin\{HasAttributes, HasContent};

/**
 * Provides the base implementation for block HTML elements.
 *
 * Subclasses return a {@see BlockInterface} tag and inherit attribute and content handling.
 *
 * Usage example:
 * ```php
 * <?= \App\Html\SomeBlock::tag()->content('Content')->render() ?>
 * ```
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
     * Usage example:
     * ```php
     * public function getTag(): BlockInterface
     * {
     *     return \UIAwesome\Html\Interop\Block::DIV;
     * }
     * ```
     *
     * @return BlockInterface Tag instance for the block element.
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
        return LineBreakNormalizer::normalize(parent::afterRun($result));
    }

    /**
     * Renders the block element.
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
     * Returns the opening tag for begin/end rendering.
     *
     * Usage example:
     * ```php
     * <?= $block->begin() ?>
     * ```
     *
     * @return string Opening HTML tag for the block element.
     */
    protected function runBegin(): string
    {
        return Html::begin($this->getTag(), $this->getAttributes());
    }
}
