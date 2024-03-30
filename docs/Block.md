# Block

The `<block>` `HTML` element represents a block of content. 

You must specify the tag name in the setter `tagName()`.

## Basic Usage

Instantiate the `Block` class using `Block::widget()`.

```php
$block = Block::widget();
```

Or, block style instantiation.

```php
<?= Block::begin() ?>
    // ... content to be wrapped by `block` element
<?= Block::end() ?>
```

## Setting Attributes

Use the provided methods to set specific attributes for the a element.

```php
// setting class attribute
$block->class('container');
```

Or, use the `attributes` method to set multiple attributes at once.

```php
$block->attributes(['class' => 'container', 'style' => 'background-color: #eee;']);
```

## Adding Content

If you want to include content within the `block` tag, use the `content` method.

```php
$block->content('MyContent');
```

Or, use `begin()` and `end()` methods to wrap content.

```php
<?= Block::begin() ?>
    My content
<?= Block::end() ?>
```

## Rendering

Generate the `HTML` output using the `render` method, for simple instantiation. 

```php
$html = $block->render();
```

For block style instantiation, use the `end()` method, which returns the `HTML` output.

```php
$html = Block::end();
```

Or, use the magic `__toString` method.

```php
$html = (string) $block;
```

## Common Use Cases

Below are examples of common use cases:

```php
// adding multiple attributes
$block->class('external')->content('MyContent');

// using data attributes
$block->dataAttributes(['analytics' => 'trackClick']);
```

Explore additional methods for setting various attributes such as `lang`, `name`, `style`, `title`, etc.

## Attributes

Refer to the [Attribute Tests](https://github.com/ui-awesome/html-core/blob/main/tests/Block/AttributeTest.php) for
comprehensive examples.

The following methods are available for setting attributes:

| Method            | Description                                                                                      |
| ----------------- | ------------------------------------------------------------------------------------------------ |
| `attributes()`    | Set multiple `attributes` at once.                                                               |
| `class()`         | Set the `class` attribute.                                                                       |
| `content()`       | Set the `content` within the `block` element.                                                    |
| `dataAttributes()`| Set multiple `data-attributes` at once.                                                          |
| `id()`            | Set the `id` attribute.                                                                          |
| `lang()`          | Set the `lang` attribute.                                                                        |
| `name()`          | Set the `name` attribute.                                                                        |
| `style()`         | Set the `style` attribute.                                                                       |
| `title()`         | Set the `title` attribute.                                                                       |

## Custom methods

Refer to the [Custom Methods Tests](https://github.com/ui-awesome/html-core/blob/main/tests/Block/CustomMethodTest.php)
for comprehensive examples.

The following methods are available for customizing the `HTML` output:

| Method    | Description                                                                                              |
| --------- | -------------------------------------------------------------------------------------------------------- |
| `begin() `| Start the `block` element.                                                                               |
| `end()`   | End the `block` element, and generate the `HTML` output.                                                 |
| `render()`| Generates the `HTML` output.                                                                             |
| `widget()`| Instantiates the `Block::class`.                                                                         |
