# Upgrade Guide

## 0.9.0

### Invalid configuration keys

`SimpleFactory::configure()`, and therefore `tag()` with `loadDefault()` and its definition arrays, now throws
`ConfigException` when a key:

- is numeric, for example a value listed without its method name, such as `['class']` (formerly skipped);
- matches no method or property of the tag (formerly skipped);
- names a `private` or `protected` method (formerly a raw `Error`) or a `static` method (formerly called);
- names a public method that does not return an instance of the tag class, such as `render` (formerly a raw
  `TypeError`).

Configuration stops at the first invalid key and returns no tag. Fix or remove such keys in `loadDefault()`, `tag()`
arguments, and any definitions array applied through `SimpleFactory::configure()`. Exceptions thrown by a public
instance method that a key calls still propagate unchanged.

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
