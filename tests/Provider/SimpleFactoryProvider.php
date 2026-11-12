<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Provider;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Factory\SimpleFactoryTest} test cases.
 */
final class SimpleFactoryProvider
{
    /**
     * Method keys of {@see \UIAwesome\Html\Core\Tests\Support\Stub\TagInline} whose public instance method does not
     * return the tag, with the arguments to pass and the expected returned type.
     *
     * @phpstan-return array<string, array{string, list<string>, string}>
     */
    public static function methodsNotReturningTag(): array
    {
        return [
            'array' => ['getAttributes', [], 'array'],
            'bool' => ['getPrefixTag', [], 'bool'],
            'null' => ['getAttribute', ['undefined'], 'null'],
            'string' => ['render', [], 'string'],
        ];
    }

    /**
     * Method names of {@see \UIAwesome\Html\Core\Tests\Support\Stub\TagInline} that are not public instance methods.
     *
     * @phpstan-return array<string, array{string}>
     */
    public static function nonPublicInstanceMethods(): array
    {
        return [
            'private method' => ['renderTag'],
            'protected method' => ['run'],
            'public static method' => ['tag'],
        ];
    }
}
