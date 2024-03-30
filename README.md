<p align="center">
    <a href="https://github.com/ui-awesome/html-core" target="_blank">
        <img src="https://avatars.githubusercontent.com/u/121752654?s=200&v=4" height="100px">
    </a>
    <h1 align="center">UI Awesome HTML Core Code Generator for PHP.</h1>
    <br>
</p>

<p align="center">
    <a href="https://github.com/ui-awesome/html-core/actions/workflows/build.yml" target="_blank">
        <img src="https://github.com/ui-awesome/html-core/actions/workflows/build.yml/badge.svg" alt="PHPUnit">
    </a>
    <a href="https://codecov.io/gh/ui-awesome/html-core" target="_blank">
        <img src="https://codecov.io/gh/ui-awesome/html-core/branch/main/graph/badge.svg?token=MF0XUGVLYC" alt="Codecov">
    </a>
    <a href="https://dashboard.stryker-mutator.io/reports/github.com/ui-awesome/html-core/main" target="_blank">
        <img src="https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fui-awesome%2Fhtml-core%2Fmain" alt="Infection">
    </a>
    <a href="https://github.com/ui-awesome/html-core/actions/workflows/static.yml" target="_blank">
        <img src="https://github.com/ui-awesome/html-core/actions/workflows/static.yml/badge.svg" alt="Psalm">
    </a>
    <a href="https://shepherd.dev/github/ui-awesome/html-core" target="_blank">
        <img src="https://shepherd.dev/github/ui-awesome/html-core/coverage.svg" alt="Psalm Coverage">
    </a>
    <a href="https://github.styleci.io/repos/779611775?branch=main">
        <img src="https://github.styleci.io/repos/779611775/shield?branch=main" alt="Style ci">
    </a>    
</p>

This package provides a set of `HTML` helper and widgets for generating `HTML` elements in a programmatic way with
`PHP`.

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```shell
composer require --prefer-dist ui-awesome/html-core:^0.1
```

or add

```json
"ui-awesome/html-core": "^0.1"
```

to the require section of your `composer.json` file. 

## Usage

### Create a new `HTML` element

To create a new `HTML` element, you can use the `HTMLBuilder::class` with the `createTag()` method.

Allowed arguments are:

- `tag` (string) - The tag name.
- `content` (string) - The content of the tag.
- `attributes` (array) - The attributes of the tag.

```php
<?php

declare(strict_types=1);

use UIAwesome\Html\Core\HTMLBuilder;
?>

<?= HTMLBuilder::createTag('div', 'Hello, World!', ['class' => 'container']) ?>
```

### Create a new `HTML` block element

To create a new `HTML` block element, you can use the `HTMLBuilder::class` with the `beginTag()` and `endTag()` methods.

Allowed arguments for `beginTag()` method are:

- `tag` (string) - The tag name.
- `attributes` (array) - The attributes of the tag.

Allowed arguments for `endTag()` method are:

- `tag` (string) - The tag name.

```php
<?php

declare(strict_types=1);

use UIAwesome\Html\Core\HTMLBuilder;

<?= HTMLBuilder::beginTag('div', ['class' => 'container']) ?>
    Hello, World!
<?= HTMLBuilder::endTag('div') ?>
```

### Generic widget

- [Tag](docs/Tag.md)
- [Block](docs/Block.md)

## Testing

[Check the documentation testing](docs/testing.md) to learn about testing.

## Support versions

[![PHP81](https://img.shields.io/badge/PHP-%3E%3D8.1-787CB5)](https://www.php.net/releases/8.1/en.php)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Our social networks

[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/Terabytesoftw)
