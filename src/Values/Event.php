<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Values;

/**
 * Represents standardized HTML global event handler attributes (the `on*` attributes).
 *
 * Provides a type-safe, standards-compliant set of event handler attribute identifiers for use in element rendering and
 * attribute helpers. Values correspond to the HTML attribute name (for example, `onclick`).
 *
 * Key features.
 * - Designed for use in tags, components, and helpers requiring event attribute assignment.
 * - Integration-ready for attribute rendering APIs.
 * - Values follow the MDN list of global event handler attributes.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Global_attributes#list_of_global_event_handler_attributes
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Event: string
{
    /**
     * `onabort` — Fired when the loading of a resource is aborted (typically media elements).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/abort_event
     */
    case ABORT = 'onabort';

    /**
     * `onanimationcancel` — Fired when a CSS Animation is cancelled.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/animationcancel_event
     */
    case ANIMATION_CANCEL = 'onanimationcancel';

    /**
     * `onanimationend` — Fired when a CSS Animation has completed.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/animationend_event
     */
    case ANIMATION_END = 'onanimationend';

    /**
     * `onanimationiteration` — Fired when a CSS Animation repeats an iteration.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/animationiteration_event
     */
    case ANIMATION_ITERATION = 'onanimationiteration';

    /**
     * `onanimationstart` — Fired when a CSS Animation starts.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/animationstart_event
     */
    case ANIMATION_START = 'onanimationstart';

    /**
     * `onauxclick` — Fired for non-primary button clicks (for example, middle-click/right-click).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/auxclick_event
     */
    case AUX_CLICK = 'onauxclick';

    /**
     * `onbeforeinput` — Fired before input occurs, allowing interception of text input.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/beforeinput_event
     */
    case BEFORE_INPUT = 'onbeforeinput';

    /**
     * `onbeforematch` — Fired before a user agent attempts to find a match for a find-in-page operation.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/beforematch_event
     */
    case BEFORE_MATCH = 'onbeforematch';

    /**
     * `onbeforetoggle` — Fired before a details element is toggled.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/beforetoggle_event
     */
    case BEFORE_TOGGLE = 'onbeforetoggle';

    /**
     * `onblur` — Fired when an element loses focus.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/blur_event
     */
    case BLUR = 'onblur';

    /**
     * `oncanplay` — Fired when the user agent can play the media, but estimates that not enough data has been
     * loaded to play the media up to its end without interruption.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/canplay_event
     */
    case CAN_PLAY = 'oncanplay';

    /**
     * `oncanplaythrough` — Fired when the user agent can play the media up to its end without interruption.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/canplaythrough_event
     */
    case CAN_PLAY_THROUGH = 'oncanplaythrough';

    /**
     * `oncancel` — Fired when a user cancels an action (for example, cancel event on inputs/dialogs).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLInputElement/cancel_event
     */
    case CANCEL = 'oncancel';

    /**
     * `onchange` — Fired when the value of an element changes (for example, input, select elements).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/change_event
     */
    case CHANGE = 'onchange';

    /**
     * `onclick` — Fired when an element is clicked.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/click_event
     */
    case CLICK = 'onclick';

    /**
     * `onclose` — Fired when a dialog closes.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLDialogElement/close_event
     */
    case CLOSE = 'onclose';

    /**
     * `oncommand` — Fired for command elements when a command is invoked.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/command_event
     */
    case COMMAND = 'oncommand';

    /**
     * `oncontentvisibilityautostatechange` — Fired when content-visibility autostate changes.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/contentvisibilityautostatechange_event
     */
    case CONTENT_VISIBILITY_AUTO_STATE_CHANGE = 'oncontentvisibilityautostatechange';

    /**
     * `oncontextlost` — Fired when the WebGL context is lost.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLCanvasElement/contextlost_event
     */
    case CONTEXT_LOST = 'oncontextlost';

    /**
     * `oncontextmenu` — Fired when the context menu is triggered (typically right-click).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/contextmenu_event
     */
    case CONTEXT_MENU = 'oncontextmenu';

    /**
     * `oncontextrestored` — Fired when a WebGL context is restored.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLCanvasElement/contextrestored_event
     */
    case CONTEXT_RESTORED = 'oncontextrestored';

    /**
     * `oncopy` — Fired when a copy operation is performed.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/copy_event
     */
    case COPY = 'oncopy';

    /**
     * `oncuechange` — Fired when the cue changes in a media track.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLTrackElement/cuechange_event
     */
    case CUE_CHANGE = 'oncuechange';

    /**
     * `oncut` — Fired when a cut operation is performed.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/cut_event
     */
    case CUT = 'oncut';

    /**
     * `ondblclick` — Fired when an element is double-clicked.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/dblclick_event
     */
    case DOUBLE_CLICK = 'ondblclick';

    /**
     * `ondrag` — Fired continuously during a drag operation.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/drag_event
     */
    case DRAG = 'ondrag';

    /**
     * `ondragend` — Fired when a drag operation ends.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dragend_event
     */
    case DRAG_END = 'ondragend';

    /**
     * `ondragenter` — Fired when a dragged item enters a valid drop target.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dragenter_event
     */
    case DRAG_ENTER = 'ondragenter';

    /**
     * `ondragleave` — Fired when a dragged item leaves a valid drop target.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dragleave_event
     */
    case DRAG_LEAVE = 'ondragleave';

    /**
     * `ondragover` — Fired when a dragged item is being dragged over a valid drop target.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dragover_event
     */
    case DRAG_OVER = 'ondragover';

    /**
     * `ondragstart` — Fired when a drag operation is initiated.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/dragstart_event
     */
    case DRAG_START = 'ondragstart';

    /**
     * `ondrop` — Fired when an item is dropped on a valid drop target.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/drop_event
     */
    case DROP = 'ondrop';

    /**
     * `ondurationchange` — Fired when the duration attribute of media changes.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/durationchange_event
     */
    case DURATION_CHANGE = 'ondurationchange';

    /**
     * `onemptied` — Fired when the media has been emptied.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/emptied_event
     */
    case EMPTIED = 'onemptied';

    /**
     * `onended` — Fired when playback has stopped because the end of the media was reached.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/ended_event
     */
    case ENDED = 'onended';

    /**
     * `onerror` — Fired when a resource failed to load or an error occurs.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/error_event
     */
    case ERROR = 'onerror';

    /**
     * `onfocus` — Fired when an element receives focus.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/focus_event
     */
    case FOCUS = 'onfocus';

    /**
     * `onfocusin` — Fired when an element or its descendants receive focus (bubbles).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/focusin_event
     */
    case FOCUS_IN = 'onfocusin';

    /**
     * `onfocusout` — Fired when an element or its descendants lose focus (bubbles).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/focusout_event
     */
    case FOCUS_OUT = 'onfocusout';

    /**
     * `onformdata` — Fired when a FormData object is constructed from a form.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLFormElement/formdata_event
     */
    case FORM_DATA = 'onformdata';

    /**
     * `onfullscreenchange` — Fired when an element enters or exits fullscreen.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/fullscreenchange_event
     */
    case FULLSCREEN_CHANGE = 'onfullscreenchange';

    /**
     * `onfullscreenerror` — Fired when a request to switch to fullscreen fails.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/fullscreenerror_event
     */
    case FULLSCREEN_ERROR = 'onfullscreenerror';

    /**
     * `ongesturechange` — Non-standard: gesture change event (touch/gesture APIs).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/gesturechange_event
     */
    case GESTURE_CHANGE = 'ongesturechange';

    /**
     * `ongestureend` — Non-standard: gesture end event.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/gestureend_event
     */
    case GESTURE_END = 'ongestureend';

    /**
     * `ongesturestart` — Non-standard: gesture start event.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/gesturestart_event
     */
    case GESTURE_START = 'ongesturestart';

    /**
     * `ongotpointercapture` — Fired when an element receives pointer capture.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/gotpointercapture_event
     */
    case GOT_POINTER_CAPTURE = 'ongotpointercapture';

    /**
     * `oninput` — Fired every time the value of an <input>, <textarea> or element with contenteditable changes.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/input_event
     */
    case INPUT = 'oninput';

    /**
     * `oninvalid` — Fired when a submittable element is invalid.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLInputElement/invalid_event
     */
    case INVALID = 'oninvalid';

    /**
     * `onkeydown` — Fired when a key is pressed down.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/keydown_event
     */
    case KEY_DOWN = 'onkeydown';

    /**
     * `onkeypress` — (Deprecated) Fired when a key that produces a character value is pressed down.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/keypress_event
     */
    case KEY_PRESS = 'onkeypress';

    /**
     * `onkeyup` — Fired when a key is released.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/keyup_event
     */
    case KEY_UP = 'onkeyup';

    /**
     * `onload` — Fired when the resource and its dependent resources have finished loading.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/load_event
     */
    case LOAD = 'onload';

    /**
     * `onloadstart` — Fired when the browser starts looking for the media data.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/loadstart_event
     */
    case LOAD_START = 'onloadstart';

    /**
     * `onloadeddata` — Fired when the media's first frame is available.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/loadeddata_event
     */
    case LOADED_DATA = 'onloadeddata';

    /**
     * `onloadedmetadata` — Fired when metadata for the media has been loaded.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/loadedmetadata_event
     */
    case LOADED_METADATA = 'onloadedmetadata';

    /**
     * `onlostpointercapture` — Fired when an element loses pointer capture.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/lostpointercapture_event
     */
    case LOST_POINTER_CAPTURE = 'onlostpointercapture';

    /**
     * `onmousedown` — Fired when a pointing device button is pressed on an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/mousedown_event
     */
    case MOUSE_DOWN = 'onmousedown';

    /**
     * `onmouseenter` — Fired when the pointing device is moved onto the element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/mouseenter_event
     */
    case MOUSE_ENTER = 'onmouseenter';

    /**
     * `onmouseleave` — Fired when the pointing device is moved off the element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/mouseleave_event
     */
    case MOUSE_LEAVE = 'onmouseleave';

    /**
     * `onmousemove` — Fired when the pointing device is moved while over an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/mousemove_event
     */
    case MOUSE_MOVE = 'onmousemove';

    /**
     * `onmouseout` — Fired when the pointing device is moved off the element or one of its children.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/mouseout_event
     */
    case MOUSE_OUT = 'onmouseout';

    /**
     * `onmouseover` — Fired when the pointing device is moved onto an element or one of its children.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/mouseover_event
     */
    case MOUSE_OVER = 'onmouseover';

    /**
     * `onmouseup` — Fired when a pointing device button is released over an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/mouseup_event
     */
    case MOUSE_UP = 'onmouseup';

    /**
     * `onmousewheel` — Deprecated/Non-standard: mouse wheel scrolling event.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/mousewheel_event
     */
    case MOUSE_WHEEL = 'onmousewheel';

    /**
     * `onpaste` — Fired when a paste action is performed.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/paste_event
     */
    case PASTE = 'onpaste';

    /**
     * `onpause` — Fired when media playback is paused.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/pause_event
     */
    case PAUSE = 'onpause';

    /**
     * `onplay` — Fired when media playback is started.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/play_event
     */
    case PLAY = 'onplay';

    /**
     * `onplaying` — Fired when playback is ready to start after having been paused or delayed due to buffering.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/playing_event
     */
    case PLAYING = 'onplaying';

    /**
     * `onpointercancel` — Fired when the browser determines that a pointer will no longer be able to generate events.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/pointercancel_event
     */
    case POINTER_CANCEL = 'onpointercancel';

    /**
     * `onpointerdown` — Fired when a pointer becomes active (pressed) on an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/pointerdown_event
     */
    case POINTER_DOWN = 'onpointerdown';

    /**
     * `onpointerenter` — Fired when a pointer enters the bounding box of an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/pointerenter_event
     */
    case POINTER_ENTER = 'onpointerenter';

    /**
     * `onpointerleave` — Fired when a pointer leaves the bounding box of an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/pointerleave_event
     */
    case POINTER_LEAVE = 'onpointerleave';

    /**
     * `onpointermove` — Fired when a pointer changes coordinates over an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/pointermove_event
     */
    case POINTER_MOVE = 'onpointermove';

    /**
     * `onpointerout` — Fired when a pointer moves out of an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/pointerout_event
     */
    case POINTER_OUT = 'onpointerout';

    /**
     * `onpointerover` — Fired when a pointer moves over an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/pointerover_event
     */
    case POINTER_OVER = 'onpointerover';

    /**
     * `onpointerrawupdate` — Fired for low-level pointer raw updates (experimental).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/pointerrawupdate_event
     */
    case POINTER_RAW_UPDATE = 'onpointerrawupdate';

    /**
     * `onpointerup` — Fired when a pointer is no longer active (released) on an element.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/pointerup_event
     */
    case POINTER_UP = 'onpointerup';

    /**
     * `onprogress` — Fired periodically to report progress of media downloading.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/progress_event
     */
    case PROGRESS = 'onprogress';

    /**
     * `onratechange` — Fired when the playback rate changes.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/ratechange_event
     */
    case RATE_CHANGE = 'onratechange';

    /**
     * `onreset` — Fired when a form is reset.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLFormElement/reset_event
     */
    case RESET = 'onreset';

    /**
     * `onresize` — Fired when an element's size changes (for example, video resize events).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLVideoElement/resize_event
     */
    case RESIZE = 'onresize';

    /**
     * `onscroll` — Fired when an element is scrolled.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/scroll_event
     */
    case SCROLL = 'onscroll';

    /**
     * `onscrollend` — Fired when scrolling ends (scroll end event).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollend_event
     */
    case SCROLL_END = 'onscrollend';

    /**
     * `onscrollsnapchange` — Experimental: Fired when scroll snap position changes.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollsnapchange_event
     */
    case SCROLL_SNAP_CHANGE = 'onscrollsnapchange';

    /**
     * `onscrollsnapchanging` — Experimental: Fired while scroll snap is changing.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollsnapchanging_event
     */
    case SCROLL_SNAP_CHANGING = 'onscrollsnapchanging';

    /**
     * `onsecuritypolicyviolation` — Fired when a Content Security Policy violation occurs.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/securitypolicyviolation_event
     */
    case SECURITY_POLICY_VIOLATION = 'onsecuritypolicyviolation';

    /**
     * `onseeked` — Fired when a seek operation completes.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/seeked_event
     */
    case SEEKED = 'onseeked';

    /**
     * `onseeking` — Fired when a seek operation begins.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/seeking_event
     */
    case SEEKING = 'onseeking';

    /**
     * `onselect` — Fired when text selection is made in an input or textarea.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLInputElement/select_event
     */
    case SELECT = 'onselect';

    /**
     * `onselectstart` — Fired when the user starts a selection.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Node/selectstart_event
     */
    case SELECT_START = 'onselectstart';

    /**
     * `onselectionchange` — Fired when the selection on the document changes.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLInputElement/selectionchange_event
     */
    case SELECTION_CHANGE = 'onselectionchange';

    /**
     * `onslotchange` — Fired when the assigned nodes of a slot change.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLSlotElement/slotchange_event
     */
    case SLOT_CHANGE = 'onslotchange';

    /**
     * `onstalled` — Fired when the user agent is trying to fetch media data, but data is unexpectedly not forthcoming.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/stalled_event
     */
    case STALLED = 'onstalled';

    /**
     * `onsubmit` — Fired when a form is submitted.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLFormElement/submit_event
     */
    case SUBMIT = 'onsubmit';

    /**
     * `onsuspend` — Fired when the user agent intentionally does not fetch media data for a period.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/suspend_event
     */
    case SUSPEND = 'onsuspend';

    /**
     * `ontimeupdate` — Fired when the current playback position changed.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/timeupdate_event
     */
    case TIME_UPDATE = 'ontimeupdate';

    /**
     * `ontoggle` — Fired when a <details> element is opened or closed.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement/toggle_event
     */
    case TOGGLE = 'ontoggle';

    /**
     * `ontouchcancel` — Fired when a touch point has been disrupted in an implementation-specific manner.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/touchcancel_event
     */
    case TOUCH_CANCEL = 'ontouchcancel';

    /**
     * `ontouchend` — Fired when a touch point is removed from the touch surface.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/touchend_event
     */
    case TOUCH_END = 'ontouchend';

    /**
     * `ontouchmove` — Fired when a touch point is moved along the touch surface.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/touchmove_event
     */
    case TOUCH_MOVE = 'ontouchmove';

    /**
     * `ontouchstart` — Fired when a touch point is placed on the touch surface.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/touchstart_event
     */
    case TOUCH_START = 'ontouchstart';

    /**
     * `ontransitioncancel` — Fired when a CSS transition is cancelled.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/transitioncancel_event
     */
    case TRANSITION_CANCEL = 'ontransitioncancel';

    /**
     * `ontransitionend` — Fired when a CSS transition has completed.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/transitionend_event
     */
    case TRANSITION_END = 'ontransitionend';

    /**
     * `ontransitionrun` — Fired when a CSS transition is about to start running.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/transitionrun_event
     */
    case TRANSITION_RUN = 'ontransitionrun';

    /**
     * `ontransitionstart` — Fired when a CSS transition starts.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/transitionstart_event
     */
    case TRANSITION_START = 'ontransitionstart';

    /**
     * `onvolumechange` — Fired when the volume has changed (media elements).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/volumechange_event
     */
    case VOLUME_CHANGE = 'onvolumechange';

    /**
     * `onwaiting` — Fired when playback has stopped because of a temporary lack of data.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/waiting_event
     */
    case WAITING = 'onwaiting';

    /**
     * `onwebkitmouseforcechanged` — Non-standard WebKit force change event.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/webkitmouseforcechanged_event
     */
    case WEBKIT_MOUSE_FORCE_CHANGED = 'onwebkitmouseforcechanged';

    /**
     * `onwebkitmouseforcedown` — Non-standard WebKit force down event.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/webkitmouseforcedown_event
     */
    case WEBKIT_MOUSE_FORCE_DOWN = 'onwebkitmouseforcedown';

    /**
     * `onwebkitmouseforceup` — Non-standard WebKit force up event.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/webkitmouseforceup_event
     */
    case WEBKIT_MOUSE_FORCE_UP = 'onwebkitmouseforceup';

    /**
     * `onwebkitmouseforcewillbegin` — Non-standard WebKit event fired when mouse force will begin.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/webkitmouseforcewillbegin_event
     */
    case WEBKIT_MOUSE_FORCE_WILL_BEGIN = 'onwebkitmouseforcewillbegin';

    /**
     * `onwheel` — Fired when a wheel button of a pointing device is rotated.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/Element/wheel_event
     */
    case WHEEL = 'onwheel';
}
