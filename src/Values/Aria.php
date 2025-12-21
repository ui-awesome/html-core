<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Values;

/**
 * Represents standardized ARIA states and properties (attributes) for HTML elements.
 *
 * Provides a type-safe, standards-compliant set of `aria-` attribute identifiers for use in element rendering,
 * attributes, and view helpers, ensuring technical consistency with the WAI-ARIA specification and MDN documentation.
 *
 * Key features.
 * - Designed for use in tags, components, and helpers requiring `aria-` attribute assignment.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of `aria-` attribute names for semantic markup generation and accessibility.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Aria: string
{
    /**
     * `aria-activedescendant` — Identifies the currently active element when focus is on a composite widget.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-activedescendant
     */
    case ACTIVEDESCENDANT = 'activedescendant';

    /**
     * `aria-atomic` — Indicates whether assistive technologies present all, or only parts of, changed region.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-atomic
     */
    case ATOMIC = 'atomic';

    /**
     * `aria-autocomplete` — Indicates whether input might be automatically completed and how predictions are presented.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-autocomplete
     */
    case AUTOCOMPLETE = 'autocomplete';

    /**
     * `aria-braillelabel` — Defines a string value that labels the current element intended to be converted into Braille.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-braillelabel
     */
    case BRAILLELABEL = 'braillelabel';

    /**
     * `aria-brailleroledescription` — Human-readable, author-localized abbreviated description for role in Braille.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-brailleroledescription
     */
    case BRAILLEROLEDESCRIPTION = 'brailleroledescription';

    /**
     * `aria-busy` — Indicates whether an element is currently being modified.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-busy
     */
    case BUSY = 'busy';

    /**
     * `aria-checked` — Indicates the current "checked" state of checkboxes, radio buttons, and other widgets.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-checked
     */
    case CHECKED = 'checked';

    /**
     * `aria-colcount` — Defines the total number of columns in a table, grid, or treegrid.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-colcount
     */
    case COLCOUNT = 'colcount';

    /**
     * `aria-colindex` — Defines an element's column index within a table, grid, or treegrid.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-colindex
     */
    case COLINDEX = 'colindex';

    /**
     * `aria-colindextext` — Human-readable text alternative of the numeric `aria-colindex`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-colindextext
     */
    case COLINDEXTEXT = 'colindextext';

    /**
     * `aria-colspan` — Defines the number of columns spanned by a cell or gridcell.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-colspan
     */
    case COLSPAN = 'colspan';

    /**
     * `aria-controls` — Identifies element(s) whose contents or presence are controlled by the element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-controls
     */
    case CONTROLS = 'controls';

    /**
     * `aria-current` — Indicates that the element represents the current item within a set.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-current
     */
    case CURRENT = 'current';

    /**
     * `aria-describedby` — Identifies the element(s) that describes the element on which it is set.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-describedby
     */
    case DESCRIBEDBY = 'describedby';

    /**
     * `aria-description` — Defines a string value that describes or annotates the current element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-description
     */
    case DESCRIPTION = 'description';

    /**
     * `aria-details` — Identifies the element(s) that provide additional information related to the object.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-details
     */
    case DETAILS = 'details';

    /**
     * `aria-disabled` — Indicates that the element is perceivable but disabled (not editable or operable).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-disabled
     */
    case DISABLED = 'disabled';

    /**
     * `aria-dropeffect` — Indicates what functions may be performed when a dragged object is released.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-dropeffect
     */
    case DROPEFFECT = 'dropeffect';

    /**
     * `aria-errormessage` — Identifies the element(s) that provides an error message for an object.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-errormessage
     */
    case ERRORMESSAGE = 'errormessage';

    /**
     * `aria-expanded` — Indicates if a control is expanded or collapsed.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-expanded
     */
    case EXPANDED = 'expanded';

    /**
     * `aria-flowto` — Identifies the next element(s) in an alternate reading order of content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-flowto
     */
    case FLOWTO = 'flowto';

    /**
     * `aria-grabbed` — Indicates an element's "grabbed" state in a drag-and-drop operation.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-grabbed
     */
    case GRABBED = 'grabbed';

    /**
     * `aria-haspopup` — Indicates the availability and type of interactive popup that can be triggered.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-haspopup
     */
    case HASPOPUP = 'haspopup';

    /**
     * `aria-hidden` — Indicates whether the element is exposed to an accessibility API.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-hidden
     */
    case HIDDEN = 'hidden';

    /**
     * `aria-invalid` — Indicates that the entered value does not conform to the expected format.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-invalid
     */
    case INVALID = 'invalid';

    /**
     * `aria-keyshortcuts` — Indicates keyboard shortcuts implemented to activate or focus an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-keyshortcuts
     */
    case KEYSHORTCUTS = 'keyshortcuts';

    /**
     * `aria-label` — Defines a string value that can be used to name an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-label
     */
    case LABEL = 'label';

    /**
     * `aria-labelledby` — Identifies the element(s) that label the element it is applied to.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-labelledby
     */
    case LABELLEDBY = 'labelledby';

    /**
     * `aria-level` — Defines the hierarchical level of an element within a structure.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-level
     */
    case LEVEL = 'level';

    /**
     * `aria-live` — Indicates that an element will be updated and describes types of updates expected.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-live
     */
    case LIVE = 'live';

    /**
     * `aria-modal` — Indicates whether an element is modal when displayed.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-modal
     */
    case MODAL = 'modal';

    /**
     * `aria-multiline` — Indicates whether a textbox accepts multiple lines of input.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-multiline
     */
    case MULTILINE = 'multiline';

    /**
     * `aria-multiselectable` — Indicates that more than one descendant may be selected.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-multiselectable
     */
    case MULTISELECTABLE = 'multiselectable';

    /**
     * `aria-orientation` — Indicates whether the element's orientation is horizontal, vertical, or unknown.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-orientation
     */
    case ORIENTATION = 'orientation';

    /**
     * `aria-owns` — Identifies an element (or elements) to define relationships when DOM hierarchy cannot.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-owns
     */
    case OWNS = 'owns';

    /**
     * `aria-placeholder` — Defines a short hint intended to help the user with data entry when control has no value.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-placeholder
     */
    case PLACEHOLDER = 'placeholder';

    /**
     * `aria-posinset` — Defines an element's number or position in the current set when not all items present.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-posinset
     */
    case POSINSET = 'posinset';

    /**
     * `aria-pressed` — Indicates the current "pressed" state of a toggle button.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-pressed
     */
    case PRESSED = 'pressed';

    /**
     * `aria-readonly` — Indicates that the element is not editable but otherwise operable.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-readonly
     */
    case READONLY = 'readonly';

    /**
     * `aria-relevant` — Indicates what notifications the user agent will trigger when a live region is modified.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-relevant
     */
    case RELEVANT = 'relevant';

    /**
     * `aria-required` — Indicates that user input is required on the element before form submission.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-required
     */
    case REQUIRED = 'required';

    /**
     * `aria-roledescription` — Defines a human-readable, author-localized description for the role.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-roledescription
     */
    case ROLEDESCRIPTION = 'roledescription';

    /**
     * `aria-rowcount` — Defines the total number of rows in a table, grid, or treegrid.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-rowcount
     */
    case ROWCOUNT = 'rowcount';

    /**
     * `aria-rowindex` — Defines an element's position with respect to the total number of rows.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-rowindex
     */
    case ROWINDEX = 'rowindex';

    /**
     * `aria-rowindextext` — Human-readable text alternative of `aria-rowindex`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-rowindextext
     */
    case ROWINDEXTEXT = 'rowindextext';

    /**
     * `aria-rowspan` — Defines the number of rows spanned by a cell or gridcell.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-rowspan
     */
    case ROWSPAN = 'rowspan';

    /**
     * `aria-selected` — Indicates the current "selected" state of various widgets.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-selected
     */
    case SELECTED = 'selected';

    /**
     * `aria-setsize` — Defines the number of items in the current set when not all items are present in the DOM.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-setsize
     */
    case SETSIZE = 'setsize';

    /**
     * `aria-sort` — Indicates if items in a table or grid are sorted in ascending or descending order.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-sort
     */
    case SORT = 'sort';

    /**
     * `aria-valuemax` — Defines the maximum allowed value for a range widget.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-valuemax
     */
    case VALUEMAX = 'valuemax';

    /**
     * `aria-valuemin` — Defines the minimum allowed value for a range widget.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-valuemin
     */
    case VALUEMIN = 'valuemin';

    /**
     * `aria-valuenow` — Defines the current value for a range widget.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-valuenow
     */
    case VALUENOW = 'valuenow';

    /**
     * `aria-valuetext` — Defines the human-readable text alternative of `aria-valuenow`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Attributes/aria-valuetext
     */
    case VALUETEXT = 'valuetext';
}
