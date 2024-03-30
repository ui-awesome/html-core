<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core;

use UIAwesome\Html\{
    Attribute\HasTabindex,
    Attribute\HasType,
    Attribute\HasValue,
    Concern\HasContent,
    Concern\HasTagName
};

/**
 * The `<tag>` HTML element represents a generic tag.
 *
 * You must specify the tag name in the setter `tagName()`.
 *
 * ```php
 * <?= Tag::widget()->tagName('span')->run() ?>
 * ```
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Block-level_elements
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element
 */
final class Tag extends Base\AbstractElement
{
    use HasContent;
    use HasTabindex;
    use HasTagName;
    use HasType;
    use HasValue;

    protected array $tokenValues = [];

    /**
     * Set the token value.
     *
     * @param array $values Token values indexed by token names.
     *
     * @return static A new instance of the current class with the specified token value.
     */
    public function tokenValues(array $values): static
    {
        $new = clone $this;
        $new->tokenValues = $values;

        return $new;
    }

    protected function run(): string
    {
        return $this->buildElement($this->tagName, $this->content, $this->tokenValues);
    }
}
