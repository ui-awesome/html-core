<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

use BackedEnum;
use UIAwesome\Html\Attribute\Global\{
    CanBeHidden,
    HasAccesskey,
    HasAria,
    HasClass,
    HasData,
    HasDir,
    HasEvents,
    HasId,
    HasLang,
    HasRole,
    HasStyle,
    HasTitle,
    HasTranslate,
};
use UIAwesome\Html\Contracts\Attribute\AttributesInterface;
use UIAwesome\Html\Contracts\Element\InlineInterface;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Element\Concern\HasElementBuilder;
use UIAwesome\Html\Mixin\{HasAttributes, HasContent, HasPrefixCollection, HasSuffixCollection, HasTemplate};

/**
 * Provides the base implementation for inline HTML elements.
 *
 * Subclasses return a {@see BackedEnum} tag and can compose prefix, tag, and suffix output via templates.
 *
 * @see https://developer.mozilla.org/en-US/docs/Glossary/Inline-level_content
 */
abstract class BaseInline extends BaseTag implements AttributesInterface, InlineInterface
{
    use CanBeHidden;
    use HasAccesskey;
    use HasAria;
    use HasAttributes;
    use HasClass;
    use HasContent;
    use HasData;
    use HasDir;
    use HasElementBuilder;
    use HasEvents;
    use HasId;
    use HasLang;
    use HasPrefixCollection;
    use HasRole;
    use HasStyle;
    use HasSuffixCollection;
    use HasTemplate;
    use HasTitle;
    use HasTranslate;

    /**
     * Returns the tag instance representing the inline element.
     *
     * @return BackedEnum Tag instance for the inline element.
     *
     * Usage example:
     * ```php
     * public function getTag(): BackedEnum
     * {
     *     return \UIAwesome\Html\Interop\Inline::SPAN;
     * }
     * ```
     */
    abstract protected function getTag(): BackedEnum;
}
