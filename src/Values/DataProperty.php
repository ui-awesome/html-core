<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Values;

/**
 * Represents standardized property names for the HTML `data-*` attributes.
 *
 * Provides a type-safe, standards-compliant set of property identifiers for use in `data-*` attribute assignment,
 * ensuring consistent naming and predictable output aligned with the HTML specification.
 *
 * Key features.
 * - Designed for use in tags, components, and helpers requiring `data-*` attribute assignment.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of data property names for semantic markup generation and interoperability.
 * - Values follow the HTML specification for `data-*` attributes.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/data-*
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum DataProperty: string
{
    /**
     * Action data property (`action`).
     *
     * Specifies an action to be performed, often used in JavaScript event delegation.
     */
    case ACTION = 'action';

    /**
     * Confirm data property (`confirm`).
     *
     * Used to trigger confirmation dialogs before an action is executed.
     */
    case CONFIRM = 'confirm';

    /**
     * Content data property (`content`).
     *
     * Stores arbitrary content or templates associated with the element.
     */
    case CONTENT = 'content';

    /**
     * Dismiss data property (`dismiss`).
     *
     * Indicates that the element dismisses or closes a parent component (for example, modals, alerts).
     */
    case DISMISS = 'dismiss';

    /**
     * Id data property (`id`).
     *
     * Used to identify a specific record or entity ID associated with the element.
     */
    case ID = 'id';

    /**
     * Key data property (`key`).
     *
     * Defines an input key or identifier, often used in dynamic lists.
     */
    case KEY = 'key';

    /**
     * Method data property (`method`).
     *
     * Specifies the HTTP method to be used for a request (for example, simulating DELETE/PUT links).
     */
    case METHOD = 'method';

    /**
     * Name data property (`name`).
     *
     * Defines the name of a field or property associated with the element.
     */
    case NAME = 'name';

    /**
     * Parent data property (`parent`).
     *
     * References a parent element ID or selector.
     */
    case PARENT = 'parent';

    /**
     * Placement data property (`placement`).
     *
     * Specifies the placement or position of a UI element (for example, tooltips, popovers).
     */
    case PLACEMENT = 'placement';

    /**
     * Target data property (`target`).
     *
     * Defines a target element selector for an action (for example, collapse target, modal target).
     */
    case TARGET = 'target';

    /**
     * Toggle data property (`toggle`).
     *
     * Indicates a UI state toggle, widely used for dropdowns, modals, and tabs.
     */
    case TOGGLE = 'toggle';

    /**
     * Trigger data property (`trigger`).
     *
     * Defines the type of event or trigger mechanism (for example, hover, click, focus).
     */
    case TRIGGER = 'trigger';

    /**
     * Url data property (`url`).
     *
     * Defines a URL or endpoint associated with the element, often for AJAX requests.
     */
    case URL = 'url';

    /**
     * Value data property (`value`).
     *
     * Stores a raw value or payload associated with the element.
     */
    case VALUE = 'value';
}
