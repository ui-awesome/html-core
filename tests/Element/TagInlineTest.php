<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use LogicException;
use PHPForge\Support\ReflectionHelper;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Attribute\Values\{
    Aria,
    ContentEditable,
    Data,
    Direction,
    Draggable,
    Event,
    Language,
    Role,
    Translate,
};
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, DefaultThemeProvider, TagInline, TagInlineWithTokenValues};
use UIAwesome\Html\Interop\{Block, Inline, Voids};

/**
 * Unit tests for {@see TagInline} element rendering and attribute handling.
 *
 * Verifies rendered output, provider application, and prefix/suffix rendering behavior for {@see TagInline}.
 *
 * Test coverage.
 * - Applies default and theme providers.
 * - Renders inline elements with representative global HTML attributes.
 * - Renders prefix and suffix content with and without wrapper tags.
 * - Throws exceptions for unsupported `begin()`/`end()` usage.
 * - Uses `SimpleFactory` defaults while preserving user overrides.
 *
 * {@see TagInline} for element implementation details.
 * {@see DefaultProvider} for default provider implementation.
 * {@see DefaultThemeProvider} for theme provider implementation.
 * {@see SimpleFactory} for default configuration management.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('element')]
final class TagInlineTest extends TestCase
{
    public function testRenderWithAccesskey(): void
    {
        self::assertSame(
            <<<HTML
            <span accesskey="k"></span>
            HTML,
            TagInline::tag()
                ->accesskey('k')
                ->render(),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::assertSame(
            <<<HTML
            <span aria-pressed="true"></span>
            HTML,
            TagInline::tag()
                ->addAriaAttribute('pressed', true)
                ->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <span aria-pressed="true"></span>
            HTML,
            TagInline::tag()
                ->addAriaAttribute(Aria::PRESSED, true)
                ->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddDataAttribute(): void
    {
        self::assertSame(
            <<<HTML
            <span data-value="value"></span>
            HTML,
            TagInline::tag()
                ->addDataAttribute('value', 'value')
                ->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttributeUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <span data-value="value"></span>
            HTML,
            TagInline::tag()
                ->addDataAttribute(Data::VALUE, 'value')
                ->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddEvent(): void
    {
        self::assertSame(
            <<<HTML
            <span onclick="handleClick()"></span>
            HTML,
            TagInline::tag()
                ->addEvent(Event::CLICK, 'handleClick()')
                ->render(),
            "Failed asserting that element renders correctly with 'addEvent()' method.",
        );
    }

    public function testRenderWithAriaAttribute(): void
    {
        self::assertSame(
            <<<HTML
            <span aria-controls="modal-1" aria-hidden="false" aria-label="Close"></span>
            HTML,
            TagInline::tag()
                ->ariaAttributes(
                    [
                        'controls' => static fn(): string => 'modal-1',
                        'hidden' => false,
                        'label' => 'Close',
                    ],
                )
                ->render(),
            "Failed asserting that element renders correctly with 'ariaAttributes()' method.",
        );
    }

    public function testRenderWithAttributes(): void
    {
        self::assertSame(
            <<<HTML
            <span class="test-class"></span>
            HTML,
            TagInline::tag()
                ->attributes(['class' => 'test-class'])
                ->render(),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::assertSame(
            <<<HTML
            <span class="test-class"></span>
            HTML,
            TagInline::tag()
                ->class('test-class')
                ->render(),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithContent(): void
    {
        self::assertSame(
            <<<HTML
            <span>Content</span>
            HTML,
            TagInline::tag()
                ->content('Content')
                ->render(),
            "Failed asserting that element renders correctly with 'content()' method.",
        );
    }

    public function testRenderWithContentEditable(): void
    {
        self::assertSame(
            <<<HTML
            <span contenteditable="true"></span>
            HTML,
            TagInline::tag()
                ->contentEditable(true)
                ->render(),
            "Failed asserting that element renders correctly with 'contentEditable' attribute.",
        );
    }

    public function testRenderWithContentEditableUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <span contenteditable="true"></span>
            HTML,
            TagInline::tag()
                ->contentEditable(ContentEditable::TRUE)
                ->render(),
            "Failed asserting that element renders correctly with 'contentEditable' attribute using enum.",
        );
    }

    public function testRenderWithCustomTokenValues(): void
    {
        self::assertSame(
            <<<HTML
            <span>Test content</span>
            <div class="custom-token">Custom content from token</div>
            HTML,
            TagInlineWithTokenValues::tag()
                ->content('Test content')
                ->template('{tag}\n{custom}')
                ->tokenValues(['{custom}' => '<div class="custom-token">Custom content from token</div>'])
                ->render(),
            'Failed asserting that element renders correctly with custom token values spread into template.',
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::assertSame(
            <<<HTML
            <span data-value="value"></span>
            HTML,
            TagInline::tag()
                ->dataAttributes(['value' => 'value'])
                ->render(),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationMethodValues(): void
    {
        self::assertSame(
            <<<HTML
            <span class="default-class" title="default-title"></span>
            HTML,
            TagInline::tag(['class' => 'default-class', 'title' => 'default-title'])->render(),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::assertSame(
            <<<HTML
            <span class="default-provider"></span>
            HTML,
            TagInline::tag()
                ->addDefaultProvider(DefaultProvider::class)
                ->render(),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        self::assertSame(
            <<<HTML
            <span></span>
            HTML,
            TagInline::tag()->render(),
            'Failed asserting that element renders correctly with default values.',
        );
    }

    public function testRenderWithDir(): void
    {
        self::assertSame(
            <<<HTML
            <span dir="rtl"></span>
            HTML,
            TagInline::tag()
                ->dir('rtl')
                ->render(),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDirUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <span dir="rtl"></span>
            HTML,
            TagInline::tag()
                ->dir(Direction::RTL)
                ->render(),
            "Failed asserting that element renders correctly with 'dir' attribute using enum.",
        );
    }

    public function testRenderWithDraggable(): void
    {
        self::assertSame(
            <<<HTML
            <span draggable="true"></span>
            HTML,
            TagInline::tag()
                ->draggable(true)
                ->render(),
            "Failed asserting that element renders correctly with 'draggable' attribute.",
        );
    }

    public function testRenderWithDraggableUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <span draggable="true"></span>
            HTML,
            TagInline::tag()
                ->draggable(Draggable::TRUE)
                ->render(),
            "Failed asserting that element renders correctly with 'draggable' attribute using enum.",
        );
    }

    public function testRenderWithEvents(): void
    {
        self::assertSame(
            <<<HTML
            <span onchange="handleChange()"></span>
            HTML,
            TagInline::tag()
                ->events(['change' => 'handleChange()'])
                ->render(),
            "Failed asserting that element renders correctly with 'events()' method.",
        );
    }

    public function testRenderWithGlobalDefaultsAreApplied(): void
    {
        SimpleFactory::setDefaults(
            TagInline::class,
            ['class' => 'from-global'],
        );

        self::assertSame(
            <<<HTML
            <span class="from-global"></span>
            HTML,
            TagInline::tag()->render(),
            'Failed asserting that global defaults are applied correctly.',
        );

        SimpleFactory::setDefaults(
            TagInline::class,
            [],
        );
    }

    public function testRenderWithHidden(): void
    {
        self::assertSame(
            <<<HTML
            <span hidden></span>
            HTML,
            TagInline::tag()
                ->hidden(true)
                ->render(),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::assertSame(
            <<<HTML
            <span id="taginline"></span>
            HTML,
            TagInline::tag()
                ->id('taginline')
                ->render(),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithItemId(): void
    {
        self::assertSame(
            <<<HTML
            <span itemid="http://example.com/item"></span>
            HTML,
            TagInline::tag()
                ->itemId('http://example.com/item')
                ->render(),
            "Failed asserting that element renders correctly with 'itemId' attribute.",
        );
    }

    public function testRenderWithItemProp(): void
    {
        self::assertSame(
            <<<HTML
            <span itemprop="name"></span>
            HTML,
            TagInline::tag()
                ->itemProp('name')
                ->render(),
            "Failed asserting that element renders correctly with 'itemProp' attribute.",
        );
    }

    public function testRenderWithItemRef(): void
    {
        self::assertSame(
            <<<HTML
            <span itemref="additional-info"></span>
            HTML,
            TagInline::tag()
                ->itemRef('additional-info')
                ->render(),
            "Failed asserting that element renders correctly with 'itemRef' attribute.",
        );
    }

    public function testRenderWithItemScope(): void
    {
        self::assertSame(
            <<<HTML
            <span itemscope></span>
            HTML,
            TagInline::tag()
                ->itemScope(true)
                ->render(),
            "Failed asserting that element renders correctly with 'itemScope' attribute.",
        );
    }

    public function testRenderWithItemType(): void
    {
        self::assertSame(
            <<<HTML
            <span itemtype="http://schema.org/Person"></span>
            HTML,
            TagInline::tag()
                ->itemType('http://schema.org/Person')
                ->render(),
            "Failed asserting that element renders correctly with 'itemType' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::assertSame(
            <<<HTML
            <span lang="es"></span>
            HTML,
            TagInline::tag()
                ->lang('es')
                ->render(),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithLangUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <span lang="es"></span>
            HTML,
            TagInline::tag()
                ->lang(Language::SPANISH)
                ->render(),
            "Failed asserting that element renders correctly with 'lang' attribute using enum.",
        );
    }

    public function testRenderWithLoadDefault(): void
    {
        $tag = TagInline::tag();

        self::assertEmpty(
            ReflectionHelper::invokeMethod($tag, 'loadDefault'),
            'Failed asserting that loading default definitions returns an empty array when no defaults are set.',
        );
    }

    public function testRenderWithPrefixAndSuffix(): void
    {
        self::assertSame(
            <<<HTML
            <strong>Prefix</strong>
            <span>Content</span>
            <em>Suffix</em>
            HTML,
            TagInline::tag()
                ->content('Content')
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
            <span class="value"></span>
            HTML,
            TagInline::tag()
                ->class('value')
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
            <span></span>
            HTML,
            TagInline::tag()->prefix('Prefix content')
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
            <span></span>
            HTML,
            TagInline::tag()->prefix('Prefix content')
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
            <span role="button"></span>
            HTML,
            TagInline::tag()
                ->role('button')
                ->render(),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithRoleUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <span role="button"></span>
            HTML,
            TagInline::tag()
                ->role(Role::BUTTON)
                ->render(),
            "Failed asserting that element renders correctly with 'role' attribute using enum.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::assertSame(
            <<<HTML
            <span style='value'></span>
            HTML,
            TagInline::tag()
                ->style('value')
                ->render(),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithSuffixSetWithoutSuffixTag(): void
    {
        self::assertSame(
            <<<HTML
            <span class="value"></span>
            Suffix content
            HTML,
            TagInline::tag()
                ->class('value')
                ->suffix('Suffix content')
                ->render(),
            "Failed asserting that element renders correctly with 'suffix()' method.",
        );
    }

    public function testRenderWithSuffixTagUsingBlockTag(): void
    {
        self::assertSame(
            <<<HTML
            <span></span>
            <div class="suffix-class" id="suffix-id">
            Suffix content
            </div>
            HTML,
            TagInline::tag()
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
            <span></span>
            <strong class="suffix-class" id="suffix-id">Suffix content</strong>
            HTML,
            TagInline::tag()
                ->suffix('Suffix content')
                ->suffixAttributes(['id' => 'suffix-id'])
                ->suffixClass('suffix-class')
                ->suffixTag(Inline::STRONG)
                ->render(),
            "Failed asserting that element renders correctly with 'suffixTag()' method.",
        );
    }

    public function testRenderWithTabindex(): void
    {
        self::assertSame(
            <<<HTML
            <span tabindex="3"></span>
            HTML,
            TagInline::tag()
                ->tabIndex(3)
                ->render(),
            "Failed asserting that element renders correctly with 'tabindex' attribute.",
        );
    }

    public function testRenderWithTemplateFallbackWhenTemplateEmpty(): void
    {
        self::assertSame(
            <<<HTML
            Prefix content
            <span>Content</span>
            Suffix content
            HTML,
            TagInline::tag()
                ->content('Content')
                ->prefix('Prefix content')
                ->suffix('Suffix content')
                ->template('')
                ->render(),
            "Failed asserting that element renders correctly when 'template()' is empty.",
        );
    }

    public function testRenderWithThemeProvider(): void
    {
        self::assertSame(
            <<<HTML
            <span class="text-muted"></span>
            HTML,
            TagInline::tag()
                ->addThemeProvider('muted', DefaultThemeProvider::class)
                ->render(),
            'Failed asserting that theme provider is applied correctly.',
        );
    }

    public function testRenderWithTitle(): void
    {
        self::assertSame(
            <<<HTML
            <span title="value"></span>
            HTML,
            TagInline::tag()
                ->title('value')
                ->render(),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithToString(): void
    {
        self::assertSame(
            <<<HTML
            <span></span>
            HTML,
            (string) TagInline::tag(),
            "Failed asserting that '__toString()' method renders correctly.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::assertSame(
            <<<HTML
            <span translate="no"></span>
            HTML,
            TagInline::tag()
                ->translate('no')
                ->render(),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithTranslateUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <span translate="no"></span>
            HTML,
            TagInline::tag()
                ->translate(Translate::NO)
                ->render(),
            "Failed asserting that element renders correctly with 'translate' attribute using enum.",
        );
    }

    public function testRenderWithUserOverridesGlobalDefaults(): void
    {
        SimpleFactory::setDefaults(
            TagInline::class,
            [
                'class' => 'from-global',
                'id' => 'taginline-id-global',
            ],
        );

        self::assertSame(
            <<<HTML
            <span class="from-global" id="taginline-id-user"></span>
            HTML,
            TagInline::tag()
                ->id('taginline-id-user')
                ->render(),
            'Failed asserting that user-defined attributes override global defaults correctly.',
        );

        SimpleFactory::setDefaults(
            TagInline::class,
            [],
        );
    }

    public function testRenderWithVoidPrefixTag(): void
    {
        self::assertSame(
            <<<HTML
            <img src="icon.svg" alt="Icon">
            <span></span>
            HTML,
            TagInline::tag()
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
            <span></span>
            <img src="icon.svg" alt="Icon">
            HTML,
            TagInline::tag()
                ->suffixAttributes(['src' => 'icon.svg', 'alt' => 'Icon'])
                ->suffixTag(Voids::IMG)
                ->render(),
            'Failed asserting that element renders correctly with a void suffix tag.',
        );
    }

    public function testReturnEmptyArrayWhenApplyThemeAndUndefinedTheme(): void
    {
        $tag = TagInline::tag();

        self::assertEmpty(
            $tag->apply($tag, ''),
            'Failed asserting that applying an undefined theme returns an empty array.',
        );
    }

    public function testReturnEmptyArrayWhenGetDefaultsAndNoDefaultsSet(): void
    {
        $tag = TagInline::tag();

        self::assertEmpty(
            $tag->getDefaults($tag),
            'Failed asserting that getting defaults returns an empty array when no defaults are set.',
        );
    }

    public function testThrowLogicExceptionForBeginCalled(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            Message::TAG_DOES_NOT_SUPPORT_BEGIN->getMessage(TagInline::class),
        );

        TagInline::tag()->begin();
    }

    public function testThrowLogicExceptionForEndCalled(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            Message::UNEXPECTED_END_CALL_NO_BEGIN->getMessage(TagInline::class),
        );

        TagInline::tag()::end();
    }
}
