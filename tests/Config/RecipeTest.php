<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Config;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Config\{Cookbook, Recipe};
use UIAwesome\Html\Core\Exception\Message;

/**
 * Unit tests for the {@see Recipe} class.
 */
#[Group('config')]
final class RecipeTest extends TestCase
{
    public function testPreservesNameAndCookbook(): void
    {
        $cookbook = new Cookbook();
        $recipe = new Recipe('flowbite.field', $cookbook);

        self::assertSame(
            'flowbite.field',
            $recipe->name,
            'Failed asserting that the recipe name is preserved.',
        );
        self::assertSame(
            $cookbook,
            $recipe->cookbook,
            'Failed asserting that the cookbook instance is preserved.',
        );
    }

    public function testThrowInvalidArgumentExceptionForEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Recipe name'),
        );

        new Recipe('', new Cookbook());
    }

    public function testThrowInvalidArgumentExceptionForNameWithSurroundingWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage('Recipe name'),
        );

        new Recipe(' flowbite.field', new Cookbook());
    }
}
