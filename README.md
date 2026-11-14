<!-- markdownlint-disable MD041 -->
<p align="center">
    <a href="https://github.com/ui-awesome/html-core" target="_blank">
        <img src="https://raw.githubusercontent.com/ui-awesome/.github/refs/heads/main/logo/ui_awesome.png" alt="UI Awesome" width="25%">
    </a>
    <h1 align="center">Html Core</h1>
    <br>
</p>
<!-- markdownlint-enable MD041 -->

<p align="center">
    <a href="https://github.com/ui-awesome/html-core/actions/workflows/build.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/ui-awesome/html-core/build.yml?style=for-the-badge&label=PHPUnit&logo=github" alt="PHPUnit">
    </a>
    <a href="https://codecov.io/github/ui-awesome/html-core" target="_blank">
        <img src="https://img.shields.io/codecov/c/github/ui-awesome/html-core.svg?style=for-the-badge&logo=codecov&logoColor=white&label=Coverage" alt="Coverage">
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
    <em>Build and render block, inline, input, and void elements with immutable fluent APIs.</em>
</p>

## Features

<picture>
    <source media="(max-width: 767px)" srcset="https://raw.githubusercontent.com/ui-awesome/html-core/main/docs/svgs/features-mobile.svg">
    <img src="https://raw.githubusercontent.com/ui-awesome/html-core/main/docs/svgs/features.svg" alt="Feature Overview" style="width: 100%;">
</picture>

### Installation

```bash
composer require ui-awesome/html-core:^0.8
```

### Quick start

#### Rendering HTML tags with enums

Renders begin/end tags and full elements using standards-compliant tag enums.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Interop\{Block, Inline, Voids};

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
use UIAwesome\Html\Interop\Block;

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
use UIAwesome\Html\Interop\Voids;

echo Html::void(
    Voids::IMG,
    [
        'class' => ['void'],
        'data' => ['role' => 'presentation'],
    ],
);

// <img class="void" data-role="presentation">
```

#### Input elements with prefix/suffix templates

Input elements render the input tag with optional prefix and suffix segments through the same template primitives used
by inline elements.

```php
<?php

declare(strict_types=1);

namespace App;

use BackedEnum;
use UIAwesome\Html\Core\Element\BaseInput;
use UIAwesome\Html\Interop\{Inline, Voids};

final class SearchInput extends BaseInput
{
    protected function getTag(): BackedEnum
    {
        return Voids::INPUT;
    }

    protected function run(): string
    {
        return $this->buildElement();
    }
}

echo SearchInput::tag()
    ->type('search')
    ->name('q')
    ->prefix('Search')
    ->prefixTag(Inline::LABEL)
    ->render();

// <label>Search</label>
// <input name="q" type="search">
```

#### Building custom elements with immutable fluent APIs

Create your own element classes by extending the provided base elements.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Interop\Block;
use BackedEnum;

final class Div extends BaseBlock
{
    protected function getTag(): BackedEnum
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

`BaseBlock` implements `ClearableContentInterface`. Use `$element->clearContent()` to obtain an empty-content clone
without changing attributes or the original instance. Chain `->content($value)` to append encoded replacement text
or `->html($trustedHtml)` to append trusted raw HTML. Calling `content('')` alone does not clear existing content.

#### Nested rendering with `begin()` / `end()`

`BaseBlock` supports stack-based begin/end rendering, with protection against mismatched tags.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Interop\Block;
use BackedEnum;

final class Div extends BaseBlock
{
    protected function getTag(): BackedEnum
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
use UIAwesome\Html\Interop\Inline;
use BackedEnum;

final class Span extends BaseInline
{
    protected function getTag(): BackedEnum
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

#### Application-scoped config recipes

Use an immutable `Config` instance to apply a design-system recipe without global mutable state. Multiple configs can be
used in the same process, and fluent calls made after `config()` are local overrides.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Config\{Call, ComponentContext, Config, Cookbook, Recipe};
use UIAwesome\Html\Core\Element\BaseInline;
use UIAwesome\Html\Core\Theme\ThemeInterface;
use UIAwesome\Html\Interop\Inline;
use BackedEnum;

final class Span extends BaseInline
{
    protected function getTag(): BackedEnum
    {
        return Inline::SPAN;
    }

    protected function run(): string
    {
        return $this->buildElement($this->getContent());
    }
}

final readonly class FlowbiteTheme implements ThemeInterface
{
    public function getName(): string
    {
        return 'flowbite';
    }

    public function getRecipes(ComponentContext $context): iterable
    {
        if ($context->component === 'badge') {
            yield new Recipe(
                'flowbite.badge',
                new Cookbook(new Call('class', 'rounded text-sm')),
            );
        }
    }
}

$config = new Config(new FlowbiteTheme());

echo Span::tag()
    ->config($config, new ComponentContext('badge'))
    ->id('badge-1')
    ->content('New')
    ->render();

// <span class="rounded text-sm" id="badge-1">New</span>
```

#### Application-scoped theming

Theming is dependency injection, not global state. Build **one** `Config` in the application container from the theme
and the applier, inject it where components are created, and apply it per component with a `ComponentContext`. The
library holds no static or global theme registry, so parallel tests, multiple tenants, and several design systems can
coexist in the same process.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Config\{ComponentContext, Config, ConfigApplier};

// Container definition, built once per application.
$container->set(
    Config::class,
    static fn(): Config => new Config(new FlowbiteTheme(), new ConfigApplier()),
);

// Consumer, receiving the config by injection.
final readonly class Badge
{
    public function __construct(private Config $config) {}

    public function render(string $label): string
    {
        return Span::tag()
            ->config($this->config, new ComponentContext('badge'))
            ->content($label)
            ->render();
    }
}
```

Fluent calls made after `config()` are local overrides, and each `Config` instance applies only its own recipes.

The component identifier, the `variant`, `size`, and `scheme` qualifiers, the states, and `hasState()` also accept a
string-backed enum. The context stores the backing value, so themes keep comparing plain strings. An int-backed enum
throws `InvalidArgumentException`.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Config\ComponentContext;

enum BadgeName: string
{
    case BADGE = 'badge';
    case PILL = 'pill';
}

$context = new ComponentContext(BadgeName::BADGE, variant: BadgeName::PILL, states: ['active']);

$context->component; // 'badge'
$context->variant; // 'pill'
$context->hasState('active'); // true
```

#### Class-level defaults with `loadDefault()`

For a simpler approach without a theme, override `loadDefault()` in your tag class. These defaults are applied
automatically when `tag()` is called.

```php
<?php

declare(strict_types=1);

namespace App;

use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Interop\Block;
use BackedEnum;

final class Container extends BaseBlock
{
    protected function getTag(): BackedEnum
    {
        return Block::DIV;
    }

    protected function loadDefault(): array
    {
        return [
            'class' => 'container',
        ];
    }
}

echo Container::tag()->render();
// <div class="container">
// </div>

echo Container::tag(['class' => 'container-fluid'])->render();
// <div class="container container-fluid">
// </div>
```

Each key in `loadDefault()` and in the arrays passed to `tag()` must name a public instance method or property of the
tag, and a method must return the tag, as fluent setters do. A numeric key, such as a value listed without its method
name, an unknown key, such as a misspelled method name, or a method returning another value, such as `render`, throws
`ConfigException`.

Configuration priority (from weakest to strongest):

1. Class defaults from `loadDefault()`
2. Defaults passed to `tag()`
3. Application-scoped recipes applied by `config()`
4. Fluent local overrides called after `config()`

#### Extensibility

This library is agnostic and designed to be extended. You can define your own tag collections (for example, for SVG,
MathML, or Web Components) with custom string-backed enums.

- `Html::element()` handles generic open/content/close rendering.
- `Html::inline()` handles inline rendering.
- `Html::void()` handles void rendering.

You can create a custom enum for your specific domain and use it with `html-core`.

```php
enum SvgTag: string
{
    case SVG = 'svg';
    case G = 'g';
    // ... add other SVG block tags as needed
}

// now you can use it with the Html renderer or your custom classes
echo Html::element(SvgTag::G, '...');
// <g>...</g>
```

## Documentation

For detailed configuration options and advanced usage.

- 🧪 [Testing Guide](https://github.com/ui-awesome/html-core/blob/main/docs/testing.md)
- ⬆️ [Upgrade Guide](UPGRADE.md)

## AI assistance

AI agents: read the [documentation index](https://yii2-framework.github.io/docs/llms.txt) and fetch the Markdown version
of a page by appending `index.md` to its URL. The
[AI agents guide](https://github.com/yii2-framework/docs/blob/main/src/content/docs/project/ai-agents.md) covers skill
installation, client setup and verification.

- 🤖 [`ui-awesome-html-core` skill](https://github.com/ui-awesome/html-core/blob/main/docs/agents.md): custom block,
  inline, input and void elements, the `Html` renderer, block begin/end rendering, `SimpleFactory` defaults and
  application-scoped theme configuration through `Config` recipes.

See the [repository guides](#documentation), the [skill source](skills/ui-awesome-html-core/SKILL.md), the source PHPDoc
and the [changelog](CHANGELOG.md).

## Package information

[![PHP](https://img.shields.io/badge/%3E%3D8.3-777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/releases/8.3/en.php)
[![Latest Stable Version](https://img.shields.io/packagist/v/ui-awesome/html-core.svg?style=for-the-badge&logo=packagist&logoColor=white&label=Stable)](https://packagist.org/packages/ui-awesome/html-core)
[![Total Downloads](https://img.shields.io/packagist/dt/ui-awesome/html-core.svg?style=for-the-badge&logo=composer&logoColor=white&label=Downloads)](https://packagist.org/packages/ui-awesome/html-core)

## Project status

[![PHPStan Level Max](https://img.shields.io/badge/PHPStan-Level%20Max-4F5D95.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.com/ui-awesome/html-core/actions/workflows/static.yml)
[![Quality](https://img.shields.io/github/actions/workflow/status/ui-awesome/html-core/quality.yml?style=for-the-badge&label=Quality&logo=github)](https://github.com/ui-awesome/html-core/actions/workflows/quality.yml)
[![StyleCI](https://img.shields.io/badge/dynamic/xml?url=https%3A%2F%2Fgithub.styleci.io%2Frepos%2F779611775%2Fshield%3Fbranch%3Dmain&query=%2F%2F*%5Blocal-name%28%29%3D%27text%27%5D%5B2%5D&label=StyleCI&style=for-the-badge&logo=github&logoColor=white&color=4F5D95)](https://github.styleci.io/repos/779611775?branch=main)

## Security

[![OpenSSF Scorecard](https://api.scorecard.dev/projects/github.com/ui-awesome/html-core/badge?style=for-the-badge)](https://scorecard.dev/viewer/?uri=github.com/ui-awesome/html-core)
[![Zizmor](https://img.shields.io/github/actions/workflow/status/ui-awesome/html-core/security.yml?style=for-the-badge&label=Zizmor&logo=github)](https://github.com/ui-awesome/html-core/actions/workflows/security.yml)

## Built with AI

[![Built with Claude Code](https://img.shields.io/badge/Built%20with-Claude%20Code-D97757.svg?style=for-the-badge&logo=claude&logoColor=white)](https://claude.com/claude-code)
[![Built with Codex](https://img.shields.io/badge/Built%20with-Codex-10A37F.svg?style=for-the-badge&logo=openaigym&logoColor=white)](https://openai.com/codex)
[![Reviewed by CodeRabbit](https://img.shields.io/badge/Reviewed%20by-CodeRabbit-FF570A.svg?style=for-the-badge&logo=coderabbit&logoColor=white)](https://www.coderabbit.ai)

## Our social networks

[![Follow on X](https://img.shields.io/badge/-Follow%20on%20X-1DA1F2.svg?style=for-the-badge&logo=x&logoColor=white&labelColor=000000)](https://x.com/Terabytesoftw)
[![Follow on Facebook](https://img.shields.io/badge/-Follow%20on%20Facebook-1877F2.svg?style=for-the-badge&logo=facebook&logoColor=white&labelColor=000000)](https://www.facebook.com/wilmer.arambula.9)

## License

[![License](https://img.shields.io/badge/License-BSD--3--Clause-brightgreen.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=555555)](LICENSE)
