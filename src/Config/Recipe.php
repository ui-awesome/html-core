<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

use InvalidArgumentException;
use UIAwesome\Html\Core\Exception\Message;

use function preg_match;

/**
 * Associates an identifiable theme recipe with its ordered cookbook.
 *
 * By convention, the recipe name is prefixed with the theme identifier (for example, `flowbite.button`) so error
 * messages and diagnostics trace the originating theme without extra plumbing.
 *
 * Usage example:
 * ```php
 * $recipe = new \UIAwesome\Html\Core\Config\Recipe(
 *     'flowbite.button',
 *     new \UIAwesome\Html\Core\Config\Cookbook(new \UIAwesome\Html\Core\Config\Call('class', 'btn-primary')),
 * );
 * ```
 */
final readonly class Recipe
{
    /**
     * @param string $name Recipe identifier used to trace which recipe configured a component.
     * @param Cookbook $cookbook Ordered config calls applied by the recipe.
     *
     * @throws InvalidArgumentException If the recipe name is empty or contains whitespace.
     */
    public function __construct(public string $name, public Cookbook $cookbook)
    {
        if ($name === '' || preg_match('/[\s\p{Z}\p{C}]/u', $name) !== 0) {
            throw new InvalidArgumentException(
                Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Recipe name'),
            );
        }
    }
}
