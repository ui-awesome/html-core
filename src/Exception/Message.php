<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Exception;

use function sprintf;

/**
 * Represents error message templates.
 *
 * This enum defines formatted error messages for various error conditions that may occur during operations such as
 * tag handling and event management.
 *
 * It provides message templates that can be formatted at call sites.
 *
 * Each case represents a specific type of error, with a message template that can be populated with dynamic values
 * using the {@see Message::getMessage()} method.
 *
 * Each message template can be formatted with arguments.
 *
 * Key features.
 * - Can be used by exception call sites that need formatted messages.
 * - Defines message templates as enum cases.
 * - Formats templates with `sprintf()` via {@see Message::getMessage()}.
 * - Supports message formatting with dynamic parameters.
 * - Uses the enum case `value` as the template string.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
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
     * Returns the formatted message string for the error case.
     *
     * @param int|string ...$argument Values to insert into the message template.
     *
     * @return string Formatted error message with interpolated arguments.
     *
     * Usage example:
     * ```php
     * throw new InvalidArgumentException(Message::CANNOT_INSTANTIATE_ABSTRACT_CLASS->getMessage(MyAbstractClass::class));
     * ```
     */
    public function getMessage(int|string ...$argument): string
    {
        return sprintf($this->value, ...$argument);
    }
}
