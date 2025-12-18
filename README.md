<!-- markdownlint-disable MD041 -->
<p align="center">
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/ui-awesome/.github/refs/heads/main/logo/ui_awesome_dark.png">
        <source media="(prefers-color-scheme: light)" srcset="https://raw.githubusercontent.com/ui-awesome/.github/refs/heads/main/logo/ui_awesome_light.png">
        <img src="https://raw.githubusercontent.com/ui-awesome/.github/refs/heads/main/logo/ui_awesome_dark.png" alt="Yii Framework" width="150px">
    </picture>
    <h1 align="center">Html core</h1>
    <br>
</p>
<!-- markdownlint-enable MD041 -->

<p align="center">
    <a href="https://github.com/ui-awesome/html-core/actions/workflows/build.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/ui-awesome/html-core/build.yml?style=for-the-badge&label=PHPUnit&logo=github" alt="PHPUnit">
    </a>
    <a href="https://dashboard.stryker-mutator.io/reports/github.com/ui-awesome/html-core/main" target="_blank">
        <img src="https://img.shields.io/endpoint?style=for-the-badge&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fui-awesome%2Fhtml-core%2Fmain" alt="Mutation Testing">
    </a>
    <a href="https://github.com/ui-awesome/html-core/actions/workflows/static.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/ui-awesome/html-core/static.yml?style=for-the-badge&label=PHPStan&logo=github" alt="PHPStan">
    </a>
</p>

<p align="center">
    <strong>A type-safe PHP library for standards-compliant HTML tag rendering</strong><br>
    <em>Build and render block, inline, list, root, table, and void elements with immutable fluent APIs.</em>
</p>

## Features

<picture>
    <source media="(min-width: 768px)" srcset="./docs/svgs/features.svg">
    <img src="./docs/svgs/features-mobile.svg" alt="Feature Overview" style="width: 100%;">
</picture>

### Installation

```bash
composer require ui-awesome/html-core:^0.1
```

### Quick start

#### Rendering HTML tags with enums

Renders begin/end tags and full elements using standards-compliant tag enums.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Tag\{Block, Inline, Voids};

echo Html::begin(Block::DIV, ['class' => 'container']);
// <div class="container">

echo Html::inline(Inline::SPAN, 'Hello');
// <span>Hello</span>

echo Html::end(Block::DIV);
// </div>
```

#### Rendering a full element (with optional content encoding)

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Tag\Block;

$content = '<span>Test Content</span>';

echo Html::element(Block::DIV, $content, ['class' => 'test-class']);

// <div class="test-class">
// <span>Test Content</span>
// </div>

echo Html::element(Block::DIV, $content, ['class' => 'test-class'], true);

// <div class="test-class">
// &lt;span&gt;Test Content&lt;/span&gt;
// </div>
```

#### Rendering void elements with structured attributes

Void tags render without closing tags. Complex attributes (like `class` arrays and `data` arrays) are rendered via the
installed `ui-awesome/html-helper` dependency.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Tag\Voids;

echo Html::void(
    Voids::IMG,
    [
        'class' => ['void'],
        'data' => ['role' => 'presentation'],
    ],
);

// <img class="void" data-role="presentation">
```

#### Building custom elements with immutable fluent APIs

Create your own element classes by extending the provided base elements.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Core\Tag\Block;

final class Div extends BaseBlock
{
    protected function getTag(): Block
    {
        return Block::DIV;
    }
}

echo Div::tag()
    ->class('card')
    ->content('Content')
    ->render();

// <div class="card">
// Content
// </div>
```

#### Nested rendering with `begin()` / `end()`

`BaseBlock` supports stack-based begin/end rendering, with protection against mismatched tags.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Core\Tag\Block;

final class Div extends BaseBlock
{
    protected function getTag(): Block
    {
        return Block::DIV;
    }
}

echo Div::tag()->begin();
echo 'Nested Content';
echo Div::end();

// <div>
// Nested Content
// </div>
```

#### Inline elements with prefix/suffix and templates

Inline elements can render prefix and suffix segments, optionally wrapped in their own tags.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Element\BaseInline;
use UIAwesome\Html\Core\Tag\Inline;

final class Span extends BaseInline
{
    protected function getTag(): Inline
    {
        return Inline::SPAN;
    }

    protected function run(): string
    {
        return $this->buildElement($this->getContent());
    }
}

echo Span::tag()
    ->content('Content')
    ->prefix('Prefix')
    ->prefixTag(Inline::STRONG)
    ->suffix('Suffix')
    ->suffixTag(Inline::EM)
    ->render();

// <strong>Prefix</strong>
// <span>Content</span>
// <em>Suffix</em>
```

#### Defaults and theming via providers

You can apply configuration through global defaults, per-instance defaults, and optional default/theme providers.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Element\BaseInline;
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Provider\{DefaultsProviderInterface, ThemeProviderInterface};
use UIAwesome\Html\Core\Tag\Inline;

final class Span extends BaseInline
{
    protected function getTag(): Inline
    {
        return Inline::SPAN;
    }

    protected function run(): string
    {
        return $this->buildElement($this->getContent());
    }
}

final class Defaults implements DefaultsProviderInterface
{
    public function getDefaults(BaseTag $tag): array
    {
        return ['class' => 'badge'];
    }
}

final class Theme implements ThemeProviderInterface
{
    public function apply(BaseTag $tag, string $theme): array
    {
        return $theme === 'muted' ? ['class' => 'text-muted'] : [];
    }
}

SimpleFactory::setDefaults(Span::class, ['title' => 'from-global']);

echo Span::tag(['id' => 'badge-1'])
    ->addDefaultProvider(Defaults::class)
    ->addThemeProvider('muted', Theme::class)
    ->content('New')
    ->render();

// <span class="badge text-muted" id="badge-1" title="from-global">New</span>
```

## Documentation

For detailed configuration options and advanced usage.

- [Testing Guide](docs/testing.md)

## Package information

[![PHP](https://img.shields.io/badge/%3E%3D8.1-777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/releases/8.1/en.php)
[![Latest Stable Version](https://img.shields.io/packagist/v/ui-awesome/html-core.svg?style=for-the-badge&logo=packagist&logoColor=white&label=Stable)](https://packagist.org/packages/ui-awesome/html-core)
[![Total Downloads](https://img.shields.io/packagist/dt/ui-awesome/html-core.svg?style=for-the-badge&logo=composer&logoColor=white&label=Downloads)](https://packagist.org/packages/ui-awesome/html-core)

## Quality code

[![Codecov](https://img.shields.io/codecov/c/github/ui-awesome/html-core.svg?style=for-the-badge&logo=codecov&logoColor=white&label=Coverage)](https://codecov.io/github/ui-awesome/html-core)
[![PHPStan Level Max](https://img.shields.io/badge/PHPStan-Level%20Max-4F5D95.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.com/ui-awesome/html-core/actions/workflows/static.yml)
[![Super-Linter](https://img.shields.io/github/actions/workflow/status/ui-awesome/html-core/linter.yml?style=for-the-badge&label=Super-Linter&logo=github)](https://github.com/ui-awesome/html-core/actions/workflows/linter.yml)
[![StyleCI](https://img.shields.io/badge/StyleCI-Passed-44CC11.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.styleci.io/repos/779611775?branch=main)

## Our social networks

[![Follow on X](https://img.shields.io/badge/-Follow%20on%20X-1DA1F2.svg?style=for-the-badge&logo=x&logoColor=white&labelColor=000000)](https://x.com/Terabytesoftw)

## License

[![License](https://img.shields.io/badge/License-BSD--3--Clause-brightgreen.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=555555)](LICENSE)
