<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;
use UIAwesome\Html\Core\Exception\Message;

use function array_is_list;
use function count;

/**
 * Stores an ordered immutable collection of config calls.
 *
 * Usage example:
 * ```php
 * $cookbook = new \UIAwesome\Html\Core\Config\Cookbook(
 *     new \UIAwesome\Html\Core\Config\Call('class', 'btn-primary'),
 *     new \UIAwesome\Html\Core\Config\Call('id', 'submit'),
 * );
 * ```
 *
 * @implements IteratorAggregate<int, Call>
 */
final readonly class Cookbook implements Countable, IteratorAggregate
{
    /**
     * Ordered config calls.
     *
     * @var list<Call>
     */
    public array $calls;

    /**
     * @param Call ...$calls Ordered config calls stored by the cookbook.
     *
     * @throws InvalidArgumentException If the calls are passed by name.
     */
    public function __construct(Call ...$calls)
    {
        if (array_is_list($calls) === false) {
            throw new InvalidArgumentException(
                Message::COOKBOOK_CALLS_MUST_BE_POSITIONAL_LIST->getMessage(),
            );
        }

        $this->calls = $calls;
    }

    /**
     * Returns the number of config calls.
     *
     * Usage example:
     * ```php
     * $total = count($cookbook);
     * ```
     *
     * @return int<0, max> Number of config calls.
     */
    public function count(): int
    {
        return count($this->calls);
    }

    /**
     * Returns an iterator over the ordered config calls.
     *
     * Usage example:
     * ```php
     * foreach ($cookbook as $call) {
     *     echo $call->method;
     * }
     * ```
     *
     * @return Traversable<int, Call>
     */
    public function getIterator(): Traversable
    {
        yield from $this->calls;
    }

    /**
     * Whether the cookbook contains no config calls.
     *
     * Usage example:
     * ```php
     * $isEmpty = $cookbook->isEmpty();
     * ```
     *
     * @return bool `true` if the cookbook has no calls, `false` otherwise.
     */
    public function isEmpty(): bool
    {
        return $this->calls === [];
    }
}
