<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

use InvalidArgumentException;
use UIAwesome\Html\Core\Config\{ComponentContext, Recipe};
use UIAwesome\Html\Core\Theme\ThemeInterface;

use function array_is_list;

/**
 * Theme stub for config tests.
 */
final readonly class Theme implements ThemeInterface
{
    /**
     * Ordered theme recipes.
     *
     * @var list<Recipe>
     */
    private array $recipes;

    public function __construct(private string $name, Recipe ...$recipes)
    {
        if (array_is_list($recipes) === false) {
            throw new InvalidArgumentException('Theme recipes must be an ordered positional list.');
        }

        $this->recipes = $recipes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRecipes(ComponentContext $context): iterable
    {
        yield from $this->recipes;
    }
}
