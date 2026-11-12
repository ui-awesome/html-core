<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Factory;

use Error;
use LogicException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Exception\{ConfigException, Message};

use function get_debug_type;
use function is_array;
use function is_string;
use function method_exists;
use function property_exists;

/**
 * Creates and configures tag instances from cookbook-style definitions.
 */
final class SimpleFactory
{
    /**
     * Applies configuration values to a tag instance.
     *
     * Keys resolve to methods first, then to properties, and must name a public instance member. A method must return
     * an instance of the tag class, such as the clone returned by an immutable setter. A numeric key, or a key matching
     * no method or property, aborts the configuration with {@see ConfigException}.
     *
     * Property writes rejected at runtime, such as `readonly`, asymmetric visibility, or type mismatches, surface as
     * {@see ConfigException} with the original `Error` attached as the previous exception.
     *
     * @param BaseTag $tag Tag instance to configure.
     * @param array $defaults Associative array of method names and arguments.
     *
     * @throws ConfigException if a key is numeric, matches no method or property, resolves to a method that is not a
     * public instance method or does not return an instance of the tag class, resolves to a property that is not a
     * public instance property, or resolves to a public property that rejects the write.
     *
     * @return BaseTag Configured tag instance.
     *
     * @phpstan-template T of BaseTag
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
                throw new ConfigException(
                    Message::CONFIG_KEY_MUST_BE_STRING->getMessage($tag::class, $action),
                );
            }

            if (method_exists($tag, $action)) {
                $method = new ReflectionMethod($tag, $action);

                if ($method->isPublic() === false || $method->isStatic()) {
                    throw new ConfigException(
                        Message::CONFIG_METHOD_MUST_BE_PUBLIC->getMessage($tag::class, $action),
                    );
                }

                /**
                 * @phpstan-ignore method.dynamicName
                 */
                $configured = $tag->$action(...(is_array($value) ? $value : [$value]));

                if (($configured instanceof $tag) === false) {
                    throw new ConfigException(
                        Message::CONFIG_METHOD_MUST_RETURN_TAG->getMessage(
                            $tag::class,
                            $action,
                            get_debug_type($configured),
                        ),
                    );
                }

                $tag = $configured;
            } elseif (property_exists($tag, $action)) {
                $property = new ReflectionProperty($tag, $action);

                if ($property->isPublic() === false || $property->isStatic()) {
                    throw new ConfigException(
                        Message::CONFIG_PROPERTY_MUST_BE_PUBLIC->getMessage($tag::class, $action),
                    );
                }

                try {
                    /**
                     * @phpstan-ignore property.dynamicName
                     */
                    $tag->$action = $value;
                } catch (Error $e) {
                    throw new ConfigException(
                        Message::CONFIG_PROPERTY_MUST_BE_WRITABLE->getMessage($tag::class, $action),
                        previous: $e,
                    );
                }
            } else {
                throw new ConfigException(
                    Message::CONFIG_KEY_MUST_MATCH_METHOD_OR_PROPERTY->getMessage($tag::class, $action),
                );
            }
        }

        return $tag;
    }

    /**
     * Creates a non-abstract tag instance by class name.
     *
     * @param string $class Tag class name.
     *
     * @throws LogicException if the class is abstract and cannot be instantiated.
     * @throws ReflectionException
     *
     * @return BaseTag Instantiated tag object.
     *
     * @phpstan-template T of BaseTag
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
