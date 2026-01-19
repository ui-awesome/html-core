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
 * Base class for constructing void HTML elements.
 *
 * Provides the shared implementation for void elements rendered through {@see Html}. Subclasses supply the tag via
 * {@see BaseVoid::getTag()}, and attributes are managed via mixins.
 *
 * Intended for tag classes that represent void elements (no child content) with attribute-based configuration.
 *
 * Key features.
 * - Exposes fluent attribute configuration through attribute traits.
 * - Mixes in global attribute traits and attribute storage.
 * - Renders void tags via {@see Html::void()}.
 * - Represents void elements that do not render child content.
 * - Requires subclasses to provide a {@see VoidInterface} tag.
 *
 * {@see VoidInterface} for contract details.
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
     * Must be implemented by subclasses to specify the concrete void tag.
     *
     * @return VoidInterface Tag instance for the void element.
     *
     * Usage example:
     * ```php
     * public function getTag(): VoidInterface
     * {
     *    return Void::IMG;
     * }
     * ```
     */
    abstract protected function getTag(): VoidInterface;

    /**
     * Renders the void element.
     *
     * Constructs the element by rendering the tag with the configured attributes.
     *
     * @return string Rendered HTML for the void element.
     */
    protected function run(): string
    {
        return Html::void($this->getTag(), $this->getAttributes());
    }
}
