<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

use ReflectionMethod;
use Throwable;
use UIAwesome\Html\Core\Exception\{ConfigException, Message};

use function get_debug_type;
use function method_exists;

/**
 * Applies ordered cookbook calls to fluent component instances.
 *
 * Calls must target public instance methods and return the same component type. Non-strict mode skips unavailable
 * methods and incompatible return values; exceptions thrown by an invoked method always fail.
 */
final readonly class ConfigApplier implements ConfigApplierInterface
{
    /**
     * Applies a recipe and returns the configured component instance.
     *
     * @param object $component Component to configure.
     * @param Recipe $recipe Resolved recipe to apply.
     * @param ComponentContext $context Semantic component context.
     * @param bool $strict Whether unavailable methods or incompatible return values must fail instead of being
     * skipped. Exceptions thrown by an invoked method always fail, regardless of this flag.
     *
     * @throws ConfigException If a call is unavailable or returns an incompatible value in strict mode, or throws
     * during execution in any mode.
     *
     * @return object Configured component instance.
     */
    public function apply(
        object $component,
        Recipe $recipe,
        ComponentContext $context,
        bool $strict = true,
    ): object {
        foreach ($recipe->cookbook as $call) {
            $reflection = $this->getPublicInstanceMethod($component, $call->method);

            if ($reflection === null) {
                if ($strict) {
                    throw new ConfigException(
                        Message::CONFIG_CALL_METHOD_NOT_AVAILABLE->getMessage(
                            $call->method,
                            $recipe->name,
                            $context->component,
                            $component::class,
                        ),
                    );
                }

                continue;
            }

            try {
                $configured = $reflection->invokeArgs($component, $call->arguments);
            } catch (Throwable $exception) {
                throw new ConfigException(
                    Message::CONFIG_CALL_EXECUTION_FAILED->getMessage(
                        $call->method,
                        $recipe->name,
                        $context->component,
                        $component::class,
                        $exception->getMessage(),
                    ),
                    previous: $exception,
                );
            }

            if ($configured instanceof $component) {
                $component = $configured;

                continue;
            }

            if ($strict) {
                throw new ConfigException(
                    Message::CONFIG_CALL_RETURNED_INCOMPATIBLE_VALUE->getMessage(
                        $call->method,
                        $recipe->name,
                        $context->component,
                        $component::class,
                        get_debug_type($configured),
                    ),
                );
            }
        }

        return $component;
    }

    private function getPublicInstanceMethod(object $component, string $method): ReflectionMethod|null
    {
        if (method_exists($component, $method) === false) {
            return null;
        }

        $reflection = new ReflectionMethod($component, $method);

        return $reflection->isPublic() && $reflection->isStatic() === false ? $reflection : null;
    }
}
