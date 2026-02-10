<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use PHPForge\Support\ReflectionHelper;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Attribute\Values\{Aria, Data, Direction, Event, Language, Role, Translate};
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, TagInput, TagInputWithTokenValues};
use UIAwesome\Html\Interop\{Block, Inline, Voids};

/**
 * Unit tests for {@see TagInput} element rendering.
 *
 * Verifies rendered output for input elements including global attributes and prefix/suffix composition using block,
 * inline and void tags.
 *
 * {@see TagInput} for element implementation details.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('element')]
final class TagInputTest extends TestCase
{
    public function testRenderWithAccesskey(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" accesskey="k">
            HTML,
            TagInput::tag()
                ->accesskey('k')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-pressed="true">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('pressed', true)
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-pressed="true">
            HTML,
            TagInput::tag()
                ->addAriaAttribute(Aria::PRESSED, true)
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddAriaDescribedByString(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-describedby="custom-help">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', 'custom-help')
                ->id('taginput')
                ->render(),
            "Failed asserting that an explicit 'aria-describedby' string value is preserved.",
        );
    }

    public function testRenderWithAddAriaDescribedByTrueBooleanValue(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-describedby="taginput-help">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', true)
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to "
            . "'true'.",
        );
    }

    public function testRenderWithAddAriaDescribedByTrueBooleanValueAndIdNull(): void
    {
        self::assertSame(
            <<<HTML
            <input>
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', true)
                ->id(null)
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to "
            . "'true' and 'id' is 'null'.",
        );
    }

    public function testRenderWithAddAriaDescribedByTrueBooleanValueAndPrefixSuffix(): void
    {
        self::assertSame(
            <<<HTML
            <span>Prefix</span>
            <input id="taginput" aria-describedby="taginput-help">
            <span>Suffix</span>
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', true)
                ->id('taginput')
                ->prefix('Prefix')
                ->prefixTag(Inline::SPAN)
                ->suffix('Suffix')
                ->suffixTag(Inline::SPAN)
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to "
            . "'true' and prefix/suffix.",
        );
    }

    public function testRenderWithAddAriaDescribedByTrueBooleanValueString(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-describedby="taginput-help">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', 'true')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to "
            . "'true'.",
        );
    }

    public function testRenderWithAddAriaDescribedByTrueStringValueAndPrefixSuffix(): void
    {
        self::assertSame(
            <<<HTML
            <span>Prefix</span>
            <input id="taginput" aria-describedby="taginput-help">
            <span>Suffix</span>
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', 'true')
                ->id('taginput')
                ->prefix('Prefix')
                ->prefixTag(Inline::SPAN)
                ->suffix('Suffix')
                ->suffixTag(Inline::SPAN)
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to "
            . "'true' and prefix/suffix.",
        );
    }

    public function testRenderWithAddDataAttribute(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" data-value="value">
            HTML,
            TagInput::tag()
                ->addDataAttribute('value', 'value')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttributeUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" data-value="value">
            HTML,
            TagInput::tag()
                ->addDataAttribute(Data::VALUE, 'value')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddEvent(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" onclick="handleClick()">
            HTML,
            TagInput::tag()
                ->addEvent(Event::CLICK, 'handleClick()')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'addEvent()' method.",
        );
    }

    public function testRenderWithAriaAttributes(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-label="Close" aria-hidden="false" aria-controls="modal-1">
            HTML,
            TagInput::tag()
                ->ariaAttributes(
                    [
                        'label' => 'Close',
                        'hidden' => false,
                        'controls' => static fn(): string => 'modal-1',
                    ],
                )
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'ariaAttributes()' method.",
        );
    }

    public function testRenderWithAriaAttributesAndAriaDescribedByTrueBooleanValue(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-describedby="taginput-help">
            HTML,
            TagInput::tag()
                ->ariaAttributes(['describedby' => true])
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to true.",
        );
    }

    public function testRenderWithAriaAttributesAndAriaDescribedByTrueStringValue(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-describedby="taginput-help">
            HTML,
            TagInput::tag()
                ->ariaAttributes(['describedby' => 'true'])
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to true.",
        );
    }

    public function testRenderWithAttributes(): void
    {
        self::assertSame(
            <<<HTML
            <input class="value" id="taginput">
            HTML,
            TagInput::tag()
                ->attributes(['class' => 'value'])
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithAttributesAndAriaDescribedByTrueBooleanValue(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-describedby="taginput-help">
            HTML,
            TagInput::tag()
                ->attributes(['aria-describedby' => true])
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to true.",
        );
    }

    public function testRenderWithAttributesAndAriaDescribedByTrueStringValue(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-describedby="taginput-help">
            HTML,
            TagInput::tag()
                ->attributes(['aria-describedby' => 'true'])
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to true.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::assertSame(
            <<<HTML
            <input class="value" id="taginput">
            HTML,
            TagInput::tag()
                ->class('value')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithCustomTokenValues(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput">
            <span class="custom-token">Custom content from token</span>
            HTML,
            TagInputWithTokenValues::tag()
                ->id('taginput')
                ->template("{tag}\n{custom}")
                ->tokenValues(['{custom}' => '<span class="custom-token">Custom content from token</span>'])
                ->render(),
            'Failed asserting that element renders correctly with custom token values spread into template.',
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" data-value="test-value">
            HTML,
            TagInput::tag()
                ->dataAttributes(['value' => 'test-value'])
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationValues(): void
    {
        self::assertSame(
            <<<HTML
            <input class="default-class" id="taginput" title="default-title">
            HTML,
            TagInput::tag(['class' => 'default-class', 'title' => 'default-title'])
                ->id('taginput')
                ->render(),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::assertSame(
            <<<HTML
            <input class="default-provider" id="taginput">
            HTML,
            TagInput::tag()
                ->addDefaultProvider(DefaultProvider::class)
                ->id('taginput')
                ->render(),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        self::assertSame(
            <<<HTML
            <input>
            HTML,
            TagInput::tag()
                ->id(null)
                ->render(),
            'Failed asserting that element renders correctly with default values.',
        );
    }

    public function testRenderWithDir(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" dir="rtl">
            HTML,
            TagInput::tag()
                ->dir('rtl')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDirUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" dir="ltr">
            HTML,
            TagInput::tag()
                ->dir(Direction::LTR)
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'dir' attribute using enum.",
        );
    }

    public function testRenderWithDisabled(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" disabled>
            HTML,
            TagInput::tag()
                ->disabled(true)
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'disabled' attribute.",
        );
    }

    public function testRenderWithEvents(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" onchange="handleChange()">
            HTML,
            TagInput::tag()
                ->events(['change' => 'handleChange()'])
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'events()' method.",
        );
    }

    public function testRenderWithForm(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" form="signup-form">
            HTML,
            TagInput::tag()
                ->form('signup-form')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'form' attribute.",
        );
    }

    public function testRenderWithGenerateId(): void
    {
        /** @phpstan-var string $id */
        $id = TagInput::tag()->getAttribute('id', '');

        self::assertMatchesRegularExpression(
            '/^taginput-\w+$/',
            $id,
            'Failed asserting that element generates an ID when not provided.',
        );
    }

    public function testRenderWithGlobalDefaultsAreApplied(): void
    {
        $previous = SimpleFactory::getDefaults(TagInput::class);

        SimpleFactory::setDefaults(
            TagInput::class,
            ['class' => 'from-global'],
        );

        self::assertSame(
            <<<HTML
            <input class="from-global" id="taginput">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->render(),
            'Failed asserting that global defaults are applied correctly.',
        );

        SimpleFactory::setDefaults(
            TagInput::class,
            $previous,
        );
    }

    public function testRenderWithHidden(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" hidden>
            HTML,
            TagInput::tag()
                ->hidden(true)
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" lang="es">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->lang('es')
                ->render(),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithLangUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" lang="es">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->lang(Language::SPANISH)
                ->render(),
            "Failed asserting that element renders correctly with 'lang' attribute using enum.",
        );
    }

    public function testRenderWithLoadDefault(): void
    {
        $tag = TagInput::tag();

        $defaults = ReflectionHelper::invokeMethod($tag, 'loadDefault');

        self::assertIsArray(
            $defaults,
            "Failed asserting that 'loadDefault()' method returns an array.",
        );
        self::assertIsArray(
            $defaults['id'] ?? null,
            "Failed asserting that default 'id' is an array in 'loadDefault()' method.",
        );
        self::assertIsString(
            $defaults['id'][0] ?? null,
            "Failed asserting that default 'id' template is a string in 'loadDefault()' method.",
        );
        self::assertStringContainsString(
            'taginput-',
            $defaults['id'][0],
            "Failed asserting that default 'id' is generated correctly in 'loadDefault()' method.",
        );
        self::assertSame(
            ["{prefix}\n{tag}\n{suffix}"],
            $defaults['template'] ?? [],
            'Failed asserting that default definitions are applied correctly.',
        );
    }

    public function testRenderWithName(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" name="username">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->name('username')
                ->render(),
            "Failed asserting that element renders correctly with 'name' attribute.",
        );
    }

    public function testRenderWithPrefixAndSuffix(): void
    {
        self::assertSame(
            <<<HTML
            <strong>Prefix</strong>
            <input id="taginput">
            <em>Suffix</em>
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->prefix('Prefix')
                ->prefixTag(Inline::STRONG)
                ->suffix('Suffix')
                ->suffixTag(Inline::EM)
                ->render(),
            "Failed asserting that element renders correctly with both 'prefix()' and 'suffix()' methods.",
        );
    }

    public function testRenderWithPrefixSetWithoutPrefixTag(): void
    {
        self::assertSame(
            <<<HTML
            Prefix content
            <input class="test" id="taginput">
            HTML,
            TagInput::tag()
                ->class('test')
                ->id('taginput')
                ->prefix('Prefix content')
                ->render(),
            "Failed asserting that element renders correctly with 'prefix()' method.",
        );
    }

    public function testRenderWithPrefixTagUsingBlockTag(): void
    {
        self::assertSame(
            <<<HTML
            <div class="prefix-class" id="prefix-id">
            Prefix content
            </div>
            <input id="taginput">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->prefix('Prefix content')
                ->prefixAttributes(['id' => 'prefix-id'])
                ->prefixClass('prefix-class')
                ->prefixTag(Block::DIV)
                ->render(),
            "Failed asserting that element renders correctly with 'prefixTag()' method using a block tag.",
        );
    }

    public function testRenderWithPrefixTagWhenPrefixSet(): void
    {
        self::assertSame(
            <<<HTML
            <strong class="prefix-class" id="prefix-id">Prefix content</strong>
            <input id="taginput">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->prefix('Prefix content')
                ->prefixAttributes(['id' => 'prefix-id'])
                ->prefixClass('prefix-class')
                ->prefixTag(Inline::STRONG)
                ->render(),
            "Failed asserting that element renders correctly with 'prefixTag()' method.",
        );
    }

    public function testRenderWithRole(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" role="button">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->role('button')
                ->render(),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithRoleUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" role="button">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->role(Role::BUTTON)
                ->render(),
            "Failed asserting that element renders correctly with 'role' attribute using enum.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" style='test-value'>
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->style('test-value')
                ->render(),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithSuffixSetWithoutSuffixTag(): void
    {
        self::assertSame(
            <<<HTML
            <input class="test" id="taginput">
            Suffix content
            HTML,
            TagInput::tag()
                ->class('test')
                ->id('taginput')
                ->suffix('Suffix content')
                ->render(),
            "Failed asserting that element renders correctly with 'suffix()' method.",
        );
    }

    public function testRenderWithSuffixTagUsingBlockTag(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput">
            <div class="suffix-class" id="suffix-id">
            Suffix content
            </div>
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->suffix('Suffix content')
                ->suffixAttributes(['id' => 'suffix-id'])
                ->suffixClass('suffix-class')
                ->suffixTag(Block::DIV)
                ->render(),
            "Failed asserting that element renders correctly with 'suffixTag()' method using a block tag.",
        );
    }

    public function testRenderWithSuffixTagWhenSuffixSet(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput">
            <strong class="suffix-class" id="suffix-id">Suffix content</strong>
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->suffix('Suffix content')
                ->suffixAttributes(['id' => 'suffix-id'])
                ->suffixClass('suffix-class')
                ->suffixTag(Inline::STRONG)
                ->render(),
            "Failed asserting that element renders correctly with 'suffixTag()' method.",
        );
    }

    public function testRenderWithTemplateFallbackWhenTemplateEmpty(): void
    {
        self::assertSame(
            <<<HTML
            Prefix content
            <input id="taginput">
            Suffix content
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->template('')
                ->prefix('Prefix content')
                ->suffix('Suffix content')
                ->render(),
            "Failed asserting that element renders correctly when 'template()' is empty.",
        );
    }

    public function testRenderWithTitle(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" title="test-value">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->title('test-value')
                ->render(),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithToString(): void
    {
        self::assertSame(
            <<<HTML
            <input>
            HTML,
            (string) TagInput::tag()->id(null),
            "Failed asserting that '__toString()' method renders correctly.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" translate="no">
            HTML,
            TagInput::tag()
                    ->id('taginput')
                    ->translate('no')
                    ->render(),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithTranslateUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" translate="yes">
            HTML,
            TagInput::tag()
                ->translate(Translate::YES)
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with 'translate' attribute using enum.",
        );
    }

    public function testRenderWithType(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" type="text">
            HTML,
            TagInput::tag()
                ->id('taginput')
                ->type('text')
                ->render(),
            "Failed asserting that element renders correctly with 'type' attribute.",
        );
    }

    public function testRenderWithUserOverridesGlobalDefaults(): void
    {
        $previous = SimpleFactory::getDefaults(TagInput::class);

        SimpleFactory::setDefaults(
            TagInput::class,
            [
                'class' => 'from-global',
                'id' => 'id-global',
            ],
        );

        self::assertSame(
            <<<HTML
            <input class="from-global" id="id-user">
            HTML,
            TagInput::tag(['id' => 'id-user'])->render(),
            'Failed asserting that user-defined attributes override global defaults correctly.',
        );

        SimpleFactory::setDefaults(
            TagInput::class,
            $previous,
        );
    }

    public function testRenderWithVoidPrefixTag(): void
    {
        self::assertSame(
            <<<HTML
            <img src="icon.svg" alt="Icon">
            <input>
            HTML,
            TagInput::tag()
                ->id(null)
                ->prefixAttributes(['src' => 'icon.svg', 'alt' => 'Icon'])
                ->prefixTag(Voids::IMG)
                ->render(),
            'Failed asserting that element renders correctly with a void prefix tag.',
        );
    }

    public function testRenderWithVoidSuffixTag(): void
    {
        self::assertSame(
            <<<HTML
            <input>
            <img src="icon.svg" alt="Icon">
            HTML,
            TagInput::tag()
                ->id(null)
                ->suffixAttributes(['src' => 'icon.svg', 'alt' => 'Icon'])
                ->suffixTag(Voids::IMG)
                ->render(),
            'Failed asserting that element renders correctly with a void suffix tag.',
        );
    }

    public function testReturnEmptyArrayWhenApplyThemeAndUndefinedTheme(): void
    {
        $tag = TagInput::tag();

        self::assertEmpty(
            $tag->apply($tag, ''),
            'Failed asserting that applying an undefined theme returns an empty array.',
        );
    }

    public function testReturnEmptyArrayWhenGetDefaultsAndNoDefaultsSet(): void
    {
        $tag = TagInput::tag();

        self::assertEmpty(
            $tag->getDefaults($tag),
            'Failed asserting that getting defaults returns an empty array when no defaults are set.',
        );
    }
}
