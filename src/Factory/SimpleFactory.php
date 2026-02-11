<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Factory;

use LogicException;
use ReflectionClass;
use ReflectionException;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Exception\Message;

use function is_array;
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
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class SimpleFactory
{
    /**
     * Stores global default configuration arrays keyed by class name.
     *
     * @phpstan-var array<class-string<BaseTag>, mixed[]>
     */
    public static array $defaults = [];

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
            $action = (string) $action;

            if (method_exists($tag, $action)) {
                /**
                 * @phpstan-var T $tag
                 * @phpstan-ignore method.dynamicName
                 */
                $tag = $tag->$action(...(is_array($value) ? $value : [$value]));
            } elseif (property_exists($tag, $action)) {
                /**
                 * @phpstan-var T $tag
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

    /**
     * Returns global defaults for a tag class.
     *
     * Usage example:
     * ```php
     * $defaults = \UIAwesome\Html\Core\Factory\SimpleFactory::getDefaults(\App\Html\SomeTag::class);
     * ```
     *
     * @param string $class Tag class name.
     *
     * @return array Default configuration array.
     *
     * @phpstan-param class-string<BaseTag> $class
     * @phpstan-return mixed[]
     */
    public static function getDefaults(string $class): array
    {
        return self::$defaults[$class] ?? [];
    }

    /**
     * Sets global defaults for a tag class.
     *
     * Usage example:
     * ```php
     * \UIAwesome\Html\Core\Factory\SimpleFactory::setDefaults(
     *     \App\Html\SomeTag::class,
     *     ['class' => 'default-class'],
     * );
     * ```
     *
     * @param string $class Tag class name.
     * @param array $defaults Default configuration array.
     *
     * @phpstan-param class-string<BaseTag> $class
     * @phpstan-param mixed[] $defaults
     */
    public static function setDefaults(string $class, array $defaults): void
    {
        self::$defaults[$class] = $defaults;
    }
}
