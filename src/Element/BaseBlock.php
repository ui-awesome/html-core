<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

use BackedEnum;
use Fiber;
use LogicException;
use RuntimeException;
use stdClass;
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
use UIAwesome\Html\Contracts\Attribute\AttributesInterface;
use UIAwesome\Html\Contracts\Element\BlockInterface;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Helper\LineBreakNormalizer;
use UIAwesome\Html\Mixin\{HasAttributes, HasContent};
use WeakMap;

use function array_pop;

/**
 * Provides the base implementation for block HTML elements.
 *
 * Subclasses return a {@see BackedEnum} tag and inherit attribute and content handling.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseBlock extends BaseTag implements AttributesInterface, BlockInterface
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
     * Tracks whether `begin()` was executed for this instance.
     */
    private bool $beginExecuted = false;

    /**
     * Stores the sentinel object for the main execution context.
     */
    private static stdClass|null $mainThread = null;

    /**
     * Stores per-context begin/end stacks.
     *
     * @phpstan-var WeakMap<object, static[]>|null
     */
    private static WeakMap|null $stack = null;

    /**
     * Returns the tag instance representing the block element.
     *
     * Usage example:
     * ```php
     * public function getTag(): BackedEnum
     * {
     *     return \UIAwesome\Html\Interop\Block::DIV;
     * }
     * ```
     *
     * @return BackedEnum Tag instance for the block element.
     */
    abstract protected function getTag(): BackedEnum;

    /**
     * Starts begin/end rendering for this instance.
     *
     * @return string Empty string for output buffering compatibility.
     */
    final public function begin(): string
    {
        $this->beginExecuted = true;

        $renderBegin = $this->runBegin();
        $stack = self::getContextStack();

        $stack[] = $this;

        self::$stack?->offsetSet(self::getContextId(), $stack);

        return $renderBegin;
    }

    /**
     * Ends the most recent begin/end rendering block for the current class.
     *
     * @throws LogicException if no matching `begin()` call is found.
     * @throws RuntimeException if the tag class does not match the expected type.
     *
     * @return string Rendered HTML tag string.
     */
    final public static function end(): string
    {
        $key = self::getContextId();
        $stack = self::getContextStack();

        if ($stack === []) {
            throw new LogicException(
                Message::UNEXPECTED_END_CALL_NO_BEGIN->getMessage(static::class),
            );
        }

        $tag = array_pop($stack);

        if ($stack === []) {
            self::$stack?->offsetUnset($key);
        } else {
            self::$stack?->offsetSet($key, $stack);
        }

        $tagClass = $tag::class;

        if ($tagClass !== static::class) {
            throw new RuntimeException(
                Message::TAG_CLASS_MISMATCH_ON_END->getMessage($tagClass, static::class),
            );
        }

        return $tag->render();
    }

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
     * Indicates whether `begin()` was executed for this instance.
     */
    protected function isBeginExecuted(): bool
    {
        return $this->beginExecuted;
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

    /**
     * Returns the identifier for the current execution context.
     *
     * @phpstan-return Fiber<mixed, mixed, mixed, mixed>|stdClass
     */
    private static function getContextId(): Fiber|stdClass
    {
        return Fiber::getCurrent() ?? self::$mainThread ??= new stdClass();
    }

    /**
     * Returns the begin/end stack for the current execution context.
     *
     * @phpstan-return array<array-key, static>
     */
    private static function getContextStack(): array
    {
        self::$stack ??= new WeakMap();

        $key = self::getContextId();

        if (self::$stack->offsetExists($key) === false) {
            self::$stack->offsetSet($key, []);
        }

        return self::$stack->offsetGet($key);
    }
}
