<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Exception;

use function sprintf;

/**
 * Represents error message templates for library exceptions.
 *
 * Use {@see Message::getMessage()} to format the template with `sprintf()` arguments.
 */
enum Message: string
{
    /**
     * Error when attempting to instantiate an abstract class.
     *
     * Format: "Cannot instantiate abstract class '%s' via 'tag()' method."
     */
    case CANNOT_INSTANTIATE_ABSTRACT_CLASS = "Cannot instantiate abstract class '%s' via 'tag()' method.";

    /**
     * Error when a component metadata key is not a non-empty string.
     *
     * Format: 'Component metadata keys must be non-empty strings.'
     */
    case COMPONENT_METADATA_KEYS_MUST_BE_NON_EMPTY_STRINGS = 'Component metadata keys must be non-empty strings.';

    /**
     * Error when component states are not a list of non-empty strings.
     *
     * Format: 'Component states must be a list of non-empty strings.'
     */
    case COMPONENT_STATES_MUST_BE_STRING_LIST = 'Component states must be a list of non-empty strings.';

    /**
     * Error when config call arguments are passed by name instead of position.
     *
     * Format: 'Config arguments must be an ordered positional list.'
     */
    case CONFIG_ARGUMENTS_MUST_BE_POSITIONAL_LIST = 'Config arguments must be an ordered positional list.';

    /**
     * Error when a config call fails during execution.
     *
     * Format: "Config call '%s' from recipe '%s' failed for component '%s' (%s): %s"
     */
    case CONFIG_CALL_EXECUTION_FAILED = "Config call '%s' from recipe '%s' failed for component '%s' (%s): %s";

    /**
     * Error when a config call does not target a public instance method.
     *
     * Format: "Config call '%s' from recipe '%s' is not a public instance method for component '%s' (%s)."
     */
    case CONFIG_CALL_METHOD_NOT_AVAILABLE = "Config call '%s' from recipe '%s' is not a public instance method for "
        . "component '%s' (%s).";

    /**
     * Error when a config call returns an incompatible value.
     *
     * Format: "Config call '%s' from recipe '%s' must return component '%s' (%s); %s returned."
     */
    case CONFIG_CALL_RETURNED_INCOMPATIBLE_VALUE = "Config call '%s' from recipe '%s' must return component '%s' "
        . '(%s); %s returned.';

    /**
     * Error when creating a component without a configured component factory.
     *
     * Format: 'Config does not define a component factory.'
     */
    case CONFIG_DOES_NOT_DEFINE_COMPONENT_FACTORY = 'Config does not define a component factory.';

    /**
     * Error when a config method name is empty or contains whitespace.
     *
     * Format: 'Config method must be a non-empty string without whitespace.'
     */
    case CONFIG_METHOD_MUST_BE_NON_EMPTY = 'Config method must be a non-empty string without whitespace.';

    /**
     * Error when a config applier returns a component incompatible with the fluent receiver.
     *
     * Format: "Config for component '%s' (%s) returned incompatible component %s."
     */
    case CONFIG_RETURNED_INCOMPATIBLE_COMPONENT = "Config for component '%s' (%s) returned incompatible component %s.";

    /**
     * Error when cookbook calls are passed by name instead of position.
     *
     * Format: 'Cookbook calls must be an ordered positional list.'
     */
    case COOKBOOK_CALLS_MUST_BE_POSITIONAL_LIST = 'Cookbook calls must be an ordered positional list.';

    /**
     * Error when an event key does not start with 'on'.
     *
     * Format: 'Event key "%s" must start with "on".'
     */
    case EVENT_KEY_MUST_START_WITH_ON = 'Event key "%s" must start with "on".';

    /**
     * Error when there is a class mismatch on `end()` call.
     *
     * Format: "Mismatched '%s::end()' call, got '%s'."
     */
    case TAG_CLASS_MISMATCH_ON_END = "Mismatched '%s::end()' call, got '%s'.";

    /**
     * Error when a tag does not support `begin()` method.
     *
     * Format: "Tag '%s' does not support 'begin()' method."
     */
    case TAG_DOES_NOT_SUPPORT_BEGIN = "Tag '%s' does not support 'begin()' method.";

    /**
     * Error when an unexpected `end()` call is made without a matching `begin()`.
     *
     * Format: "Unexpected '%s::end()' call, a matching 'begin()' is not found."
     */
    case UNEXPECTED_END_CALL_NO_BEGIN = "Unexpected '%s::end()' call, a matching 'begin()' is not found.";

    /**
     * Error when a named value is empty or contains whitespace.
     *
     * Format: '%s must be non-empty and contain no whitespace.'
     */
    case VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE = '%s must be non-empty and contain no whitespace.';

    /**
     * Returns the formatted message string for the error case.
     *
     * Usage example:
     * ```php
     * throw new \InvalidArgumentException(
     *     \UIAwesome\Html\Core\Exception\Message::CANNOT_INSTANTIATE_ABSTRACT_CLASS
     *         ->getMessage(\App\Html\MyAbstractClass::class),
     * );
     * ```
     *
     * @param int|string ...$argument Values to insert into the message template.
     *
     * @return string Formatted error message with interpolated arguments.
     */
    public function getMessage(int|string ...$argument): string
    {
        return sprintf($this->value, ...$argument);
    }
}
