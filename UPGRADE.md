# Upgrade Guide

## 0.7.0

The global `SimpleFactory::$defaults` store and its `getDefaults()` and `setDefaults()` methods were removed. Define
application-scoped recipes and apply them with `BaseTag::config()` instead:

```php
$config = new Config($applicationTheme);

$button = Button::tag()
    ->config($config, new ComponentContext('button'))
    ->id('save');
```

The config path does not share mutable state between requests, tests, themes, or tenants. Calls made after `config()`
remain local overrides.

Recipe calls must use canonical method names such as `class`. Names with a trailing parenthesis pair, such as `class()`,
are no longer normalized and fail when strict configuration is enabled.

### Defaults and theme provider API removed

`BaseTag` no longer implements `DefaultsProviderInterface` or `ThemeProviderInterface`, and the following members were
removed:

- `BaseTag::addDefaultProvider()`
- `BaseTag::addThemeProvider()`
- `BaseTag::apply()`
- `BaseTag::getDefaults()`
- `UIAwesome\Html\Core\Provider\DefaultsProviderInterface`
- `UIAwesome\Html\Core\Provider\ThemeProviderInterface`

Migrate provider classes to a `ThemeInterface` implementation and apply it through `Config` and `ComponentContext`.

Before.

```php
$button = Button::tag()
    ->addDefaultProvider(ButtonDefaultsProvider::class)
    ->addThemeProvider('dark', ButtonThemeProvider::class);
```

After.

```php
$config = new Config(new DarkTheme());

$button = Button::tag()->config($config, new ComponentContext('button'));
```

Class-level defaults previously returned by a defaults provider belong in `BaseTag::loadDefault()` or in the array
arguments passed to `tag()`; both keep working unchanged.

### Non-public property configuration

`SimpleFactory::configure()` now throws `ConfigException` instead of a raw `Error` when a configuration key resolves to
a property that is not a public instance property; keys matching no member are still skipped silently.

## 0.6.0

- Custom element `getTag()` implementations should now return `BackedEnum`.
- `BaseTag` now implements `UIAwesome\Html\Contracts\RenderableInterface`.
- Block elements (`BaseBlock`) now implement `UIAwesome\Html\Contracts\Element\BlockInterface` and `UIAwesome\Html\Contracts\Attribute\AttributesInterface`.
- Inline elements (`BaseInline`) now implement `UIAwesome\Html\Contracts\Element\InlineInterface` and `UIAwesome\Html\Contracts\Attribute\AttributesInterface`.
- Void elements (`BaseVoid`) now implement `UIAwesome\Html\Contracts\Element\VoidInterface` and `UIAwesome\Html\Contracts\Attribute\AttributesInterface`.
- Form controls (`BaseInput`) now implement `UIAwesome\Html\Contracts\Form\FormControlInterface`.

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
