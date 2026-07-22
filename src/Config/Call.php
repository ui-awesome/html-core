<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

use InvalidArgumentException;
use UIAwesome\Html\Core\Exception\Message;

use function array_is_list;
use function preg_match;

/**
 * Represents one ordered immutable cookbook method call.
 *
 * Immutability is structural: the method name and the ordered argument list cannot change after construction.
 *
 * Object arguments are stored by reference, so pass immutable values (scalars, enums, `readonly` objects) when deep
 * immutability is required.
 *
 * Usage example:
 * ```php
 * $call = new \UIAwesome\Html\Core\Config\Call('class', 'btn-primary');
 * ```
 */
final readonly class Call
{
    /**
     * Arguments passed to the configured method.
     *
     * @var list<mixed>
     */
    public array $arguments;

    /**
     * @param string $method Method name to call.
     * @param mixed ...$arguments Positional arguments passed to the method.
     *
     * @throws InvalidArgumentException If the method name is empty or contains whitespace, or if the arguments are
     * passed by name.
     */
    public function __construct(public string $method, mixed ...$arguments)
    {
        if ($method === '' || preg_match('/[\s\p{Z}\p{C}]/u', $method) !== 0) {
            throw new InvalidArgumentException(
                Message::CONFIG_METHOD_MUST_BE_NON_EMPTY->getMessage(),
            );
        }

        if (array_is_list($arguments) === false) {
            throw new InvalidArgumentException(
                Message::CONFIG_ARGUMENTS_MUST_BE_POSITIONAL_LIST->getMessage(),
            );
        }

        $this->arguments = $arguments;
    }
}
