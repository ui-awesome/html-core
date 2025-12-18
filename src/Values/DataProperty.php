<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Values;

enum DataProperty: string
{
    /**
     * Specifies an action to be performed, often used in JavaScript event delegation.
     */
    case ACTION = 'action';

    /**
     * Used to trigger confirmation dialogs before an action is executed.
     */
    case CONFIRM = 'confirm';

    /**
     * Stores arbitrary content or templates associated with the element.
     */
    case CONTENT = 'content';

    /**
     * Indicates that the element dismisses or closes a parent component (e.g., modals, alerts).
     */
    case DISMISS = 'dismiss';

    /**
     * Used to identify a specific record or entity ID associated with the element.
     */
    case ID = 'id';

    /**
     * Defines an input key or identifier, often used in dynamic lists.
     */
    case KEY = 'key';

    /**
     * Specifies the HTTP method to be used for a request (e.g., simulating DELETE/PUT links).
     */
    case METHOD = 'method';

    /**
     * Defines the name of a field or property associated with the element.
     */
    case NAME = 'name';

    /**
     * References a parent element ID or selector.
     */
    case PARENT = 'parent';

    /**
     * Specifies the placement or position of a UI element (e.g., tooltips, popovers).
     */
    case PLACEMENT = 'placement';

    /**
     * Defines a target element selector for an action (e.g., collapse target, modal target).
     */
    case TARGET = 'target';

    /**
     * Indicates a UI state toggle, widely used for dropdowns, modals, and tabs.
     */
    case TOGGLE = 'toggle';

    /**
     * Defines the type of event or trigger mechanism (e.g., hover, click, focus).
     */
    case TRIGGER = 'trigger';

    /**
     * Defines a URL or endpoint associated with the element, often for AJAX requests.
     */
    case URL = 'url';

    /**
     * Stores a raw value or payload associated with the element.
     */
    case VALUE = 'value';
}
