<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Exception;

use function sprintf;

/**
 * Represents standardized error messages.
 *
 * This enum defines formatted error messages for various error conditions that may occur during operations such as
 * value validation.
 *
 * It provides a consistent and standardized way to present error messages across the system.
 *
 * Each case represents a specific type of error, with a message template that can be populated with dynamic values
 * using the {@see Message::getMessage()} method.
 *
 * This centralized approach improves the consistency of error messages and simplifies potential internationalization.
 *
 * Key features.
 * - Centralization of an error text for easier maintenance.
 * - Consistent error handling across the system.
 * - Integration with specific exception classes.
 * - Message formatting with dynamic parameters.
 * - Standardized error messages for common and utility cases.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Message: string
{
    /**
     * Error when a attribute value is not a `scalar` or `Closure`.
     *
     * Format: "Attribute value must be of type 'scalar' or 'Closure', '%s' given."
     */
    case ATTRIBUTE_VALUE_MUST_BE_SCALAR_OR_CLOSURE = "Attribute value must be of type 'scalar' or 'Closure',"
    . "'%s' given.";

    /**
     * Error when attempting to instantiate an abstract class.
     *
     * Format: "Cannot instantiate abstract class '%s' via 'tag()' method."
     */
    case CANNOT_INSTANTIATE_ABSTRACT_CLASS = "Cannot instantiate abstract class '%s' via 'tag()' method.";

    /**
     * Error when an event key does not start with 'on'.
     *
     * Format: 'Event key "%s" must start with "on".'
     */
    case EVENT_KEY_MUST_START_WITH_ON = 'Event key "%s" must start with "on".';

    /**
     * Error when an attribute value is invalid.
     *
     * Format: 'Invalid value "%s" for attribute "%s". Expected: %s.'
     */
    case INVALID_ATTRIBUTE_VALUE = 'Invalid value "%s" for attribute "%s". Expected: %s.';

    /**
     * Error when a key is not a non-empty string.
     *
     * Format: "Key must be a non-empty string."
     */
    case KEY_MUST_BE_NON_EMPTY_STRING = 'Key must be a non-empty string.';

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
     * Returns the formatted message string for the error case.
     *
     * Retrieves and formats the error message string by interpolating the provided arguments.
     *
     * @param int|string ...$argument Dynamic arguments to insert into the message.
     *
     * @return string Error message with interpolated arguments.
     *
     * Usage example:
     * ```php
     * throw new InvalidArgumentException(Message::VALUE_CANNOT_BE_EMPTY->getMessage('status', 'active, inactive'));
     * ```
     */
    public function getMessage(int|string ...$argument): string
    {
        return sprintf($this->value, ...$argument);
    }
}
