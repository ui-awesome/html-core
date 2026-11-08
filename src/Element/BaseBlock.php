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
use UIAwesome\Html\Contracts\Element\{BlockInterface, ContentInterface};
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Mixin\{HasAttributes, HasContent};
use WeakMap;

use function array_key_last;
use function array_pop;
use function in_array;

/**
 * Provides the base implementation for block HTML elements.
 *
 * Subclasses return a {@see BackedEnum} tag and inherit attribute and content handling.
 *
 * @see https://developer.mozilla.org/en-US/docs/Glossary/Block-level_content.
 */
abstract class BaseBlock extends BaseTag implements AttributesInterface, BlockInterface, ContentInterface
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
     * Stores the sentinel object for the main execution context.
     */
    private static stdClass|null $mainThread = null;
    /**
     * Stores end operations while their lifecycle hooks and rendering execute.
     *
     * @phpstan-var WeakMap<object, static[]>|null
     */
    private static WeakMap|null $rendering = null;
    /**
     * Stores per-context begin/end stacks.
     *
     * @phpstan-var WeakMap<object, static[]>|null
     */
    private static WeakMap|null $stack = null;

    /**
     * Returns the tag instance representing the block element.
     *
     * @return BackedEnum Tag instance for the block element.
     */
    abstract protected function getTag(): BackedEnum;

    /**
     * Starts begin/end rendering for this instance.
     *
     * @return string Opening HTML tag string for the block element.
     */
    final public function begin(): string
    {
        $renderBegin = $this->runBegin();
        $stack = self::getContextStack();

        $stack[] = $this;

        self::getStackStorage()->offsetSet(self::getContextId(), $stack);

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

        $lastIndex = array_key_last($stack);

        /** @var static $tag */
        $tag = $stack[$lastIndex];

        $tagClass = $tag::class;

        if ($tagClass !== static::class) {
            throw new RuntimeException(
                Message::TAG_CLASS_MISMATCH_ON_END->getMessage($tagClass, static::class),
            );
        }

        array_pop($stack);

        if ($stack === []) {
            self::getStackStorage()->offsetUnset($key);
        } else {
            self::getStackStorage()->offsetSet($key, $stack);
        }

        $rendering = self::$rendering ??= new WeakMap();
        $frames = $rendering[$key] ?? [];
        $frames[] = $tag;
        $rendering[$key] = $frames;

        try {
            return $tag->render();
        } finally {
            $frames = $rendering[$key];

            array_pop($frames);

            if ($frames === []) {
                unset($rendering[$key]);
            } else {
                $rendering[$key] = $frames;
            }
        }
    }

    /**
     * Indicates whether this instance has an open or closing operation in the current context.
     */
    protected function isBeginExecuted(): bool
    {
        return in_array($this, self::getContextStack(), true)
            || in_array($this, self::$rendering[self::getContextId()] ?? [], true);
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
        $storage = self::getStackStorage();
        $key = self::getContextId();

        return $storage[$key] ?? [];
    }

    /**
     * Returns initialized begin/end stack storage.
     *
     * @phpstan-return WeakMap<object, static[]>
     */
    private static function getStackStorage(): WeakMap
    {
        return self::$stack ??= new WeakMap();
    }
}
