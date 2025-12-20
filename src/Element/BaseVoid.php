<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Element;

use UIAwesome\Html\Core\Attribute\{
    CanBeHidden,
    HasAccesskey,
    HasClass,
    HasData,
    HasDir,
    HasId,
    HasLang,
    HasStyle,
    HasTitle,
};
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Mixin\HasAttributes;
use UIAwesome\Html\Core\Tag\Voids;

/**
 * Base class for constructing HTML void elements according to the HTML specification.
 *
 * Provides a standards-compliant, extensible foundation for void tag rendering, supporting global HTML attributes,
 * attribute immutability, and technical consistency.
 *
 * Intended for use in components and tags that require dynamic or programmatic manipulation of void-level HTML
 * elements, supporting advanced rendering scenarios and consistent API design.
 *
 * Key features.
 * - Enforces standards-compliant handling of void tags as defined by the HTML specification.
 * - Immutable API for attribute assignment.
 * - Implements the core logic for void-level tag construction.
 * - Integrates global HTML attribute management via traits.
 * - Supports extensibility for custom void element implementations.
 *
 * @link https://developer.mozilla.org/en-US/docs/Glossary/Void_element
 * {@see Voids} for valid void-level tags.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
abstract class BaseVoid extends BaseTag
{
    use CanBeHidden;
    use HasAccesskey;
    use HasAttributes;
    use HasClass;
    use HasData;
    use HasDir;
    use HasId;
    use HasLang;
    use HasStyle;
    use HasTitle;

    /**
     * Returns the tag instance representing the void element.
     *
     * Must be implemented by subclasses to specify the concrete void tag.
     *
     * @return Voids Tag instance for the void element.
     */
    abstract protected function getTag(): Voids;

    /**
     * Renders the void element.
     *
     * Constructs the element by rendering the tag with the configured attributes.
     *
     * @return string Rendered HTML for the void element.
     */
    protected function run(): string
    {
        return Html::void($this->getTag(), $this->attributes);
    }
}
