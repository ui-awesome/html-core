<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core;

/**
 * The `<block>` HTML element represents a generic block-level element.
 *
 * You must specify the tag name in the setter `tagName()`.
 *
 * ```php
 * <?= Block::widget()->tagName('div')->run() ?>
 * ```
 *
 * or use block-level elements sintax:
 *
 * ```php
 * <?= Block::widget()->begin() ?>
 *    <p>This is a block-level element.</p>
 * <?= Block::end() ?>
 * ```
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Block-level_elements
 */
final class Block extends Base\AbstractBlockElement {}
