# Upgrade Guide

## 0.6.0

### Breaking changes

- Custom element `getTag()` implementations should now return `BackedEnum`.
- `BaseTag` now implements `UIAwesome\Html\Contracts\RenderableInterface`.
- `BaseBlock` now implements `UIAwesome\Html\Contracts\Element\BlockInterface` and `UIAwesome\Html\Contracts\Attribute\AttributesInterface`.
- `BaseInline` now implements `UIAwesome\Html\Contracts\Element\InlineInterface` and `UIAwesome\Html\Contracts\Attribute\AttributesInterface`.
- `BaseVoid` now implements `UIAwesome\Html\Contracts\Element\VoidInterface` and `UIAwesome\Html\Contracts\Attribute\AttributesInterface`.
- `BaseInput` now implements `UIAwesome\Html\Contracts\Form\FormControlInterface`.

If you extend these base classes and override contract methods, ensure signatures remain compatible with
`ui-awesome/html-contracts`.

### `begin()` and `end()` moved from `BaseTag` to `BaseBlock`

- `BaseTag` no longer exposes `begin()` and `end()`.
- `BaseBlock` now owns begin/end stack behavior.
- Inline, void, and input base elements no longer support begin/end calls.

If your code called `begin()` or `end()` on non-block elements, migrate to block element classes that extend
`BaseBlock`.

### `BaseHtml::element()` no longer auto-detects inline/void tags

- `BaseHtml::element()` now always renders a generic opening/content/closing tag structure.
- Use `BaseHtml::inline()` for inline rendering and `BaseHtml::void()` for void rendering.
- Element classes now own this selection logic where needed.

If your code previously passed inline or void tags to `Html::element()`, migrate those calls to `Html::inline()` or
`Html::void()`.
