<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

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
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Interop\VoidInterface;
use UIAwesome\Html\Mixin\HasAttributes;

/**
 * Provides the base implementation for void HTML elements.
 *
 * Subclasses return a {@see VoidInterface} tag and inherit attribute handling for rendering through
 * {@see Html::void()}.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Void_element
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseVoid extends BaseTag
{
    use CanBeHidden;
    use HasAccesskey;
    use HasAria;
    use HasAttributes;
    use HasClass;
    use HasData;
    use HasDir;
    use HasEvents;
    use HasId;
    use HasLang;
    use HasRole;
    use HasStyle;
    use HasTitle;
    use HasTranslate;

    /**
     * Returns the tag instance representing the void element.
     *
     * @return VoidInterface Tag instance for the void element.
     *
     * Usage example:
     * ```php
     * public function getTag(): VoidInterface
     * {
     *     return \UIAwesome\Html\Interop\Void::IMG;
     * }
     * ```
     */
    abstract protected function getTag(): VoidInterface;

    /**
     * Renders the void element.
     *
     * @return string Rendered HTML for the void element.
     */
    protected function run(): string
    {
        return Html::void($this->getTag(), $this->getAttributes());
    }
}
