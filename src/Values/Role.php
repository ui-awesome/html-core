<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Values;

/**
 * Represents standardized values for the HTML `role` global attribute.
 *
 * Provides a type-safe, standards-compliant set of translate identifiers for use in element rendering, attributes, and
 * view helpers, ensuring technical consistency with the HTML specification and modern web standards.
 *
 * Key features.
 * - Designed for use in tags, components, and helpers requiring role assignment.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Strict mapping of role values for semantic markup generation and accessibility.
 * - Values follow the HTML specification for role.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Role: string
{
    /**
     * Alert role (`alert`). For important, usually time-sensitive information (atomic live region).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/alert_role
     */
    case ALERT = 'alert';

    /**
     * Alertdialog role (`alertdialog`). Modal alert dialog that requires a response.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/alertdialog_role
     */
    case ALERT_DIALOG = 'alertdialog';

    /**
     * Application role (`application`). Indicates an application-like region.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/application_role
     */
    case APPLICATION = 'application';

    /**
     * Article role (`article`). Section of a page that could stand alone.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/article_role
     */
    case ARTICLE = 'article';

    /**
     * Association list role (`associationlist`). Structural role included for completeness.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case ASSOCIATIONLIST = 'associationlist';

    /**
     * Association list item key role (`associationlistitemkey`). Structural role (completeness).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case ASSOCIATIONLISTITEMKEY = 'associationlistitemkey';

    /**
     * Association list item value role (`associationlistitemvalue`). Structural role (completeness).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case ASSOCIATIONLISTITEMVALUE = 'associationlistitemvalue';

    /**
     * Banner role (`banner`). Global site header landmark.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/banner_role
     */
    case BANNER = 'banner';

    /**
     * Blockquote role (`blockquote`). Structural role for quoted sections (reference).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case BLOCKQUOTE = 'blockquote';

    /**
     * Button role (`button`). Clickable element that triggers a response.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/button_role
     */
    case BUTTON = 'button';

    /**
     * Caption role (`caption`). Structural role for captions.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case CAPTION = 'caption';

    /**
     * Cell role (`cell`). A cell in a tabular container (like `td`).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/cell_role
     */
    case CELL = 'cell';

    /**
     * Checkbox role (`checkbox`). Checkable interactive control.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/checkbox_role
     */
    case CHECKBOX = 'checkbox';

    /**
     * Code role (`code`). Structural role for code fragments.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case CODE = 'code';

    /**
     * Columnheader role (`columnheader`). Header cell for a column (like `th` scope="col").
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/columnheader_role
     */
    case COLUMN_HEADER = 'columnheader';

    /**
     * Combobox role (`combobox`). An input or button that controls a popup (listbox/grid).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/combobox_role
     */
    case COMBOBOX = 'combobox';

    /**
     * Command role (`command`). Abstract role for widgets that perform an action.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/command_role
     */
    case COMMAND = 'command';

    /**
     * Comment role (`comment`). Denotes a comment or reaction.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/comment_role
     */
    case COMMENT = 'comment';

    /**
     * Complementary role (`complementary`). Supporting section (sidebar/aside).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/complementary_role
     */
    case COMPLEMENTARY = 'complementary';

    /**
     * Composite role (`composite`). Abstract role for widgets that contain navigable descendants.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/composite_role
     */
    case COMPOSITE = 'composite';

    /**
     * Contentinfo role (`contentinfo`). Footer-like landmark (document footer).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/contentinfo_role
     */
    case CONTENTINFO = 'contentinfo';

    /**
     * Definition role (`definition`). Indicates a definition of a term or concept.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/definition_role
     */
    case DEFINITION = 'definition';

    /**
     * Deletion role (`deletion`). Structural role for deletions.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case DELETION = 'deletion';

    /**
     * Dialog role (`dialog`). Application dialog or window overlay.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/dialog_role
     */
    case DIALOG = 'dialog';

    /**
     * Directory role (`directory`). List of references to members of a group.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/directory_role
     */
    case DIRECTORY = 'directory';

    /**
     * Document role (`document`). Focusable reading region within complex widgets or apps.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/document_role
     */
    case DOCUMENT = 'document';

    /**
     * Emphasis role (`emphasis`). Structural role for emphasized text.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case EMPHASIS = 'emphasis';

    /**
     * Feed role (`feed`). Dynamic, scrollable list of articles.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/feed_role
     */
    case FEED = 'feed';

    /**
     * Figure role (`figure`). Identifies a figure when native semantics are not available.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/figure_role
     */
    case FIGURE = 'figure';

    /**
     * Form role (`form`). Identifies a group of elements equivalent to an HTML form.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/form_role
     */
    case FORM = 'form';

    /**
     * Generic role (`generic`). A nameless container with no semantic meaning.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/generic_role
     */
    case GENERIC = 'generic';

    /**
     * Grid role (`grid`). Widget containing rows of cells where position matters.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/grid_role
     */
    case GRID = 'grid';

    /**
     * Gridcell role (`gridcell`). A cell in a grid or treegrid, akin to `td`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/gridcell_role
     */
    case GRIDCELL = 'gridcell';

    /**
     * Group role (`group`). Identifies a set of UI objects not intended for summaries.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/group_role
     */
    case GROUP = 'group';

    /**
     * Heading role (`heading`). Defines a heading with an `aria-level`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/heading_role
     */
    case HEADING = 'heading';

    /**
     * Img role (`img`). Identifies content that should be considered a single image.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/img_role
     */
    case IMG = 'img';

    /**
     * Input role (`input`). Abstract role for widgets that accept user input.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/input_role
     */
    case INPUT = 'input';

    /**
     * Insertion role (`insertion`). Structural role for insertions.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case INSERTION = 'insertion';

    /**
     * Landmark abstract role (`landmark`). Abstract superclass for landmark roles.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/landmark_role
     */
    case LANDMARK = 'landmark';

    /**
     * Link role (`link`). Interactive reference to a resource.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/link_role
     */
    case LINK = 'link';

    /**
     * List role (`list`). Container for a set of items (used with `listitem`).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/list_role
     */
    case LIST = 'list';

    /**
     * Listbox role (`listbox`). Selectable list of items (may contain images).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/listbox_role
     */
    case LISTBOX = 'listbox';

    /**
     * Listitem role (`listitem`). Item inside a `list` container.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/listitem_role
     */
    case LISTITEM = 'listitem';

    /**
     * Log role (`log`). Live region where new information is added in order.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/log_role
     */
    case LOG = 'log';

    /**
     * Main role (`main`). Primary content of a document.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/main_role
     */
    case MAIN = 'main';

    /**
     * Mark role (`mark`). Denotes marked or highlighted content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/mark_role
     */
    case MARK = 'mark';

    /**
     * Marquee role (`marquee`). A live region with frequently changing non-essential info.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/marquee_role
     */
    case MARQUEE = 'marquee';

    /**
     * Math role (`math`). Indicates the content is a mathematical expression.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/math_role
     */
    case MATH = 'math';

    /**
     * Menu role (`menu`). Composite widget offering a list of choices.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/menu_role
     */
    case MENU = 'menu';

    /**
     * Menubar role (`menubar`). Presentation of `menu` usually horizontal and visible.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/menubar_role
     */
    case MENUBAR = 'menubar';

    /**
     * Menuitem role (`menuitem`). An option in a `menu` or `menubar`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/menuitem_role
     */
    case MENUITEM = 'menuitem';

    /**
     * Menuitemcheckbox role (`menuitemcheckbox`). A checkable `menuitem`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/menuitemcheckbox_role
     */
    case MENUITEM_CHECKBOX = 'menuitemcheckbox';

    /**
     * Menuitemradio role (`menuitemradio`). A radio-like `menuitem` where only one can be checked.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/menuitemradio_role
     */
    case MENUITEM_RADIO = 'menuitemradio';

    /**
     * Meter role (`meter`). Identifies an element being used as a meter.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/meter_role
     */
    case METER = 'meter';

    /**
     * Navigation role (`navigation`). Landmark for major groups of navigation links.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/navigation_role
     */
    case NAVIGATION = 'navigation';

    /**
     * None role (`none`). Synonym for `presentation`, removes implicit semantics.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/none_role
     */
    case NONE = 'none';

    /**
     * Note role (`note`). Section with ancillary or parenthetic content.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/note_role
     */
    case NOTE = 'note';

    /**
     * Option role (`option`). Selectable item in a `listbox`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/option_role
     */
    case OPTION = 'option';

    /**
     * Paragraph role (`paragraph`). Structural role for paragraphs.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case PARAGRAPH = 'paragraph';

    /**
     * Presentation role (`presentation`). Removes element's implicit ARIA semantics.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/presentation_role
     */
    case PRESENTATION = 'presentation';

    /**
     * Progressbar role (`progressbar`). Displays progress status for long tasks.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/progressbar_role
     */
    case PROGRESSBAR = 'progressbar';

    /**
     * Radio role (`radio`). A member of a set of checkable radio buttons.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/radio_role
     */
    case RADIO = 'radio';

    /**
     * Radiogroup role (`radiogroup`). Grouping of `radio` buttons.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/radiogroup_role
     */
    case RADIOGROUP = 'radiogroup';

    /**
     * Range abstract role (`range`). Generic structure role representing a range.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/range_role
     */
    case RANGE = 'range';

    /**
     * Region role (`region`). Landmark for significant document areas.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/region_role
     */
    case REGION = 'region';

    /**
     * Roletype abstract role (`roletype`). Base role from which others inherit.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/roletype_role
     */
    case ROLETYPE = 'roletype';

    /**
     * Row role (`row`). Row of cells within tabular structures.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/row_role
     */
    case ROW = 'row';

    /**
     * Rowgroup role (`rowgroup`). Group of rows within a tabular structure.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/rowgroup_role
     */
    case ROWGROUP = 'rowgroup';

    /**
     * Rowheader role (`rowheader`). Header cell for a row (like `th` scope="row").
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/rowheader_role
     */
    case ROWHEADER = 'rowheader';

    /**
     * Scrollbar role (`scrollbar`). Graphical object controlling scrolling.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/scrollbar_role
     */
    case SCROLLBAR = 'scrollbar';

    /**
     * Search role (`search`). Landmark for search functionality.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/search_role
     */
    case SEARCH = 'search';

    /**
     * Searchbox role (`searchbox`). Textbox intended for specifying search criteria.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/searchbox_role
     */
    case SEARCHBOX = 'searchbox';

    /**
     * Section abstract role (`section`). Superclass for renderable structural containment.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/section_role
     */
    case SECTION = 'section';

    /**
     * Sectionhead role (`sectionhead`). Abstract superclass for labels/summaries of sections.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/sectionhead_role
     */
    case SECTIONHEAD = 'sectionhead';

    /**
     * Select abstract role (`select`). Superclass for form widgets that allow selection.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/select_role
     */
    case SELECT = 'select';

    /**
     * Separator role (`separator`). Divider that separates sections or groups of menuitems.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/separator_role
     */
    case SEPARATOR = 'separator';

    /**
     * Slider role (`slider`). Input where user selects a value from a range.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/slider_role
     */
    case SLIDER = 'slider';

    /**
     * Spinbutton role (`spinbutton`). Range-like widget with discrete choices.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/spinbutton_role
     */
    case SPINBUTTON = 'spinbutton';

    /**
     * Status role (`status`). Advisory live region not as important as `alert`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/status_role
     */
    case STATUS = 'status';

    /**
     * Strong role (`strong`). Structural role indicating strong importance.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case STRONG = 'strong';

    /**
     * Structure abstract role (`structure`). For document structural elements.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structure_role
     */
    case STRUCTURE = 'structure';

    /**
     * Subscript role (`subscript`). Structural role for subscript text.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case SUBSCRIPT = 'subscript';

    /**
     * Suggestion role (`suggestion`). Denotes a proposed change in an editable document.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/suggestion_role
     */
    case SUGGESTION = 'suggestion';

    /**
     * Superscript role (`superscript`). Structural role for superscript text.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case SUPERSCRIPT = 'superscript';

    /**
     * Switch role (`switch`). Functionally like `checkbox` but represents on/off.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/switch_role
     */
    case SWITCH = 'switch';

    /**
     * Tab role (`tab`). Interactive element inside a `tablist`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/tab_role
     */
    case TAB = 'tab';

    /**
     * Tablist role (`tablist`). Container for a set of `tab` elements.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/tablist_role
     */
    case TABLIST = 'tablist';

    /**
     * Tabpanel role (`tabpanel`). Container for layered content associated with a `tab`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/tabpanel_role
     */
    case TABPANEL = 'tabpanel';

    /**
     * Term role (`term`). A word or phrase with an optional corresponding definition.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/term_role
     */
    case TERM = 'term';

    /**
     * Textbox role (`textbox`). Allows input of free-form text.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/textbox_role
     */
    case TEXTBOX = 'textbox';

    /**
     * Time role (`time`). Structural role for time elements.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/structural_roles
     */
    case TIME = 'time';

    /**
     * Timer role (`timer`). Numerical counter with implicit aria-live of `off`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/timer_role
     */
    case TIMER = 'timer';

    /**
     * Toolbar role (`toolbar`). Container of commonly used function buttons or controls.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/toolbar_role
     */
    case TOOLBAR = 'toolbar';

    /**
     * Tooltip role (`tooltip`). Contextual text bubble that appears on hover or focus.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/tooltip_role
     */
    case TOOLTIP = 'tooltip';

    /**
     * Tree role (`tree`). Widget for selecting items from a hierarchical collection.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/tree_role
     */
    case TREE = 'tree';

    /**
     * Treegrid role (`treegrid`). Grid whose rows can be expanded/collapsed like a tree.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/treegrid_role
     */
    case TREEGRID = 'treegrid';

    /**
     * Treeitem role (`treeitem`). An item in a `tree`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/treeitem_role
     */
    case TREEITEM = 'treeitem';

    /**
     * Widget abstract role (`widget`). Interactive component of a GUI (abstract).
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/widget_role
     */
    case WIDGET = 'widget';

    /**
     * Window role (`window`). Defines a browser or app window.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Reference/Roles/window_role
     */
    case WINDOW = 'window';
}
