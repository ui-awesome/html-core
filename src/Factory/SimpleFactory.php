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
 * Factory class for instantiating and configuring tag objects.
 *
 * Creates instances of {@see BaseTag} subclasses via reflection and applies configuration using cookbook-style arrays.
 * Configuration entries are mapped to method calls (when a method exists) or to property assignment (when a property
 * exists).
 *
 * Designed to support {@see BaseTag::tag()} and provider pipelines that apply defaults and theme definitions.
 *
 * Key features.
 * - Applies configuration by invoking methods and assigning properties when available.
 * - Creates non-abstract tag classes via {@see ReflectionClass}.
 * - Rejects abstract classes during instantiation.
 * - Stores global default configuration arrays per tag class.
 * - Supports chaining multiple configuration arrays in a deterministic order.
 *
 * @phpstan-template T of BaseTag
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class SimpleFactory
{
    /**
     * Stores global default configuration arrays for tag classes.
     *
     * Maps class names to arrays of default configuration values, applied during instantiation.
     *
     * @phpstan-var array<class-string<BaseTag>, mixed[]>
     */
    public static array $defaults = [];

    /**
     * Configures a tag instance using the provided defaults array.
     *
     * Iterates over the defaults array, invoking methods on the tag instance for each action key ending with '()'.
     *
     * Arguments are passed as arrays or single values, and the tag instance is updated if the method returns a new
     * instance.
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
     *
     * Usage example:
     * ```php
     * $element = SimpleFactory::configure(
     *     Div::tag(),
     *     [
     *        'id' => 'my-div',
     *        'class' => ['container', 'highlight'],
     *     ],
     * );
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
     * Instantiates a tag class by name, enforcing non-abstractness.
     *
     * @param string $class Tag class name.
     *
     * @throws LogicException if the class is abstract and cannot be instantiated.
     * @throws ReflectionException
     * @return BaseTag Instantiated tag object.
     *
     * @phpstan-param class-string<T> $class
     *
     * @phpstan-return T
     *
     * Usage example:
     * ```php
     * $tag = SimpleFactory::create(Div::class);
     * ```
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
     * Returns the global default configuration array for a tag class.
     *
     * Retrieves the stored defaults for the specified tag class, or an empty array if none are set.
     *
     * @param string $class Tag class name.
     *
     * @return array Default configuration array.
     *
     * @phpstan-param class-string<BaseTag> $class
     * @phpstan-return mixed[]
     *
     * Usage example:
     * ```php
     * $defaults = SimpleFactory::getDefaults(SomeTag::class);
     * ```
     */
    public static function getDefaults(string $class): array
    {
        return self::$defaults[$class] ?? [];
    }

    /**
     * Sets global default configuration for a tag class.
     *
     * Stores the provided defaults array for the specified tag class, to be applied during instantiation.
     *
     * @param string $class Tag class name.
     * @param array $defaults Default configuration array.
     *
     * @phpstan-param class-string<BaseTag> $class
     * @phpstan-param mixed[] $defaults
     *
     * Usage example:
     * ```php
     * SimpleFactory::setDefaults(SomeTag::class, ['class' => 'default-class']);
     * ```
     */
    public static function setDefaults(string $class, array $defaults): void
    {
        self::$defaults[$class] = $defaults;
    }
}
