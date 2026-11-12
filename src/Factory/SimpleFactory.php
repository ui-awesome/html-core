<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Factory;

use Error;
use LogicException;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Exception\{ConfigException, Message};

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
     * Keys resolve to public methods first, then to public instance properties. A string key matching neither aborts
     * the configuration with {@see ConfigException}. Numeric keys are skipped.
     *
     * Property writes rejected at runtime, such as `readonly`, asymmetric visibility, or type mismatches, surface as
     * {@see ConfigException} with the original `Error` attached as the previous exception.
     *
     * @param BaseTag $tag Tag instance to configure.
     * @param array $defaults Associative array of method names and arguments.
     *
     * @throws ConfigException if a key matches no method or property, resolves to a property that is not a public
     * instance property, or resolves to a public property that rejects the write.
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
                continue;
            }

            if (method_exists($tag, $action)) {
                /**
                 * @phpstan-var T
                 * @phpstan-ignore method.dynamicName
                 */
                $tag = $tag->$action(...(is_array($value) ? $value : [$value]));
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
