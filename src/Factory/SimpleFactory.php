<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Factory;

use LogicException;
use ReflectionClass;
use ReflectionException;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Exception\Message;

use function is_array;
use function is_string;
use function method_exists;
use function property_exists;

/**
 * Creates and configures tag instances from cookbook-style definitions.
 *
 * Usage example:
 * ```php
 * $tag = \UIAwesome\Html\Core\Factory\SimpleFactory::create(\App\Html\SomeTag::class);
 * $tag = \UIAwesome\Html\Core\Factory\SimpleFactory::configure($tag, ['class' => 'container']);
 * ```
 *
 * @phpstan-template T of BaseTag
 */
final class SimpleFactory
{
    /**
     * Applies configuration values to a tag instance.
     *
     * Usage example:
     * ```php
     * $tag = \UIAwesome\Html\Core\Factory\SimpleFactory::create(\App\Html\SomeTag::class);
     * $tag = \UIAwesome\Html\Core\Factory\SimpleFactory::configure(
     *     $tag,
     *     ['id' => 'my-div', 'class' => ['container', 'highlight']],
     * );
     * ```
     *
     * @param BaseTag $tag Tag instance to configure.
     * @param array $defaults Associative array of method names and arguments.
     *
     * @return BaseTag Configured tag instance.
     *
     * @phpstan-param T $tag
     * @phpstan-param mixed[] $defaults
     *
     * @phpstan-return T
     */
    public static function configure(BaseTag $tag, array $defaults): BaseTag
    {
        foreach ($defaults as $action => $value) {
            if (is_string($action) === false) {
                continue;
            }

            if (method_exists($tag, $action)) {
                /**
                 * @phpstan-var T
                 * @phpstan-ignore method.dynamicName
                 */
                $tag = $tag->$action(...(is_array($value) ? $value : [$value]));
            } elseif (property_exists($tag, $action)) {
                /**
                 * @phpstan-ignore property.dynamicName
                 */
                $tag->$action = $value;
            }
        }

        return $tag;
    }

    /**
     * Creates a non-abstract tag instance by class name.
     *
     * Usage example:
     * ```php
     * $tag = \UIAwesome\Html\Core\Factory\SimpleFactory::create(\App\Html\SomeTag::class);
     * ```
     *
     * @param string $class Tag class name.
     *
     * @throws LogicException if the class is abstract and cannot be instantiated.
     * @throws ReflectionException
     *
     * @return BaseTag Instantiated tag object.
     *
     * @phpstan-param class-string<T> $class
     *
     * @phpstan-return T
     */
    public static function create(string $class): BaseTag
    {
        $reflection = new ReflectionClass($class);

        if ($reflection->isAbstract()) {
            throw new LogicException(
                Message::CANNOT_INSTANTIATE_ABSTRACT_CLASS->getMessage($class),
            );
        }

        /** @phpstan-var T */
        return $reflection->newInstance();
    }
}
