# Upgrade Guide

## 0.7.0

### Application-scoped configuration

Global configuration through `SimpleFactory::$defaults`, `SimpleFactory::getDefaults()`, and
`SimpleFactory::setDefaults()` was removed. Apply a `Config` before fluent setters that must remain local overrides:

```php
$config = new Config($applicationTheme);

$button = Button::tag()
    ->config($config, new ComponentContext('button'))
    ->id('save');
```

Configuration call names must be canonical method names such as `class`; names such as `class()` now fail in strict
mode.

### Provider API

The defaults and theme provider interfaces and these `BaseTag` methods were removed:

- `addDefaultProvider()`
- `addThemeProvider()`
- `apply()`
- `getDefaults()`

Move application defaults to a `ThemeInterface` implementation and apply it through `Config` and `ComponentContext`.
Class defaults belong in `loadDefault()` or the arguments passed to `tag()`.

### Property configuration failures

`SimpleFactory::configure()` now throws `ConfigException` when a key targets a non-public or static property. A public
property write rejected because it is `readonly`, has asymmetric visibility, or receives an incompatible typed value
also throws `ConfigException`, with the original `Error` or `TypeError` available through `getPrevious()`.

Catch `ConfigException` instead of the former `Error` or `TypeError`. Keys matching no method or property continue to
be skipped.

## 0.6.0

### Element contracts

- Custom `getTag()` implementations must return `BackedEnum`.
- `BaseTag` implements `RenderableInterface`.
- `BaseBlock`, `BaseInline`, and `BaseVoid` implement their matching element and attribute contracts.
- `BaseInput` implements `FormControlInterface`.

Update overridden method signatures to remain compatible with those contracts.

### Block-only lifecycle

`begin()` and `end()` moved from `BaseTag` to `BaseBlock`. Replace calls on inline, void, or input elements with a
block element when begin/end rendering is required.

### Explicit element rendering

`BaseHtml::element()` no longer detects inline or void tags. Use `BaseHtml::inline()` or `BaseHtml::void()` for those
rendering modes.
