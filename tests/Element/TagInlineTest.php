<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use LogicException;
use PHPForge\Support\LineEndingNormalizer;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Attribute\Values\{Aria, ContentEditable, Data, Direction, Draggable, Language, Role, Translate};
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, DefaultThemeProvider, TagInline};
use UIAwesome\Html\Interop\Inline;

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
 * {@see TestSupport} for assertion utilities.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('element')]
final class TagInlineTest extends TestCase
{
    public function testRenderWithAccesskey(): void
    {
        self::assertEquals(
            <<<HTML
            <span accesskey="k"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->accesskey('k')->render(),
            ),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::assertEquals(
            <<<HTML
            <span aria-pressed="true"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->addAriaAttribute('pressed', true)->render(),
            ),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <span aria-pressed="true"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->addAriaAttribute(Aria::PRESSED, true)->render(),
            ),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddDataAttribute(): void
    {
        self::assertEquals(
            <<<HTML
            <span data-value="value"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->addDataAttribute('value', 'value')->render(),
            ),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttributeUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <span data-value="value"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->addDataAttribute(Data::VALUE, 'value')->render(),
            ),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method using enum.",
        );
    }

    public function testRenderWithAriaAttribute(): void
    {
        self::assertEquals(
            <<<HTML
            <span aria-controls="modal-1" aria-hidden="false" aria-label="Close"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()
                    ->ariaAttributes(
                        [
                            'controls' => static fn(): string => 'modal-1',
                            'hidden' => false,
                            'label' => 'Close',
                        ],
                    )->render(),
            ),
            "Failed asserting that element renders correctly with 'ariaAttributes()' method.",
        );
    }

    public function testRenderWithAttributes(): void
    {
        self::assertEquals(
            <<<HTML
            <span class="test-class"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->attributes(['class' => 'test-class'])->render(),
            ),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::assertEquals(
            <<<HTML
            <span class="test-class"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->class('test-class')->render(),
            ),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithContent(): void
    {
        self::assertEquals(
            <<<HTML
            <span>Content</span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->content('Content')->render(),
            ),
            "Failed asserting that element renders correctly with 'content()' method.",
        );
    }

    public function testRenderWithContentEditable(): void
    {
        self::assertEquals(
            <<<HTML
            <span contenteditable="true"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->contentEditable(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'contentEditable' attribute.",
        );
    }

    public function testRenderWithContentEditableUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <span contenteditable="true"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->contentEditable(ContentEditable::TRUE)->render(),
            ),
            "Failed asserting that element renders correctly with 'contentEditable' attribute using enum.",
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::assertEquals(
            <<<HTML
            <span data-value="test-value"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->dataAttributes(['value' => 'test-value'])->render(),
            ),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationMethodValues(): void
    {
        self::assertEquals(
            <<<HTML
            <span class="default-class" title="default-title"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag(['class' => 'default-class', 'title' => 'default-title'])->render(),
            ),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::assertEquals(
            <<<HTML
            <span class="default-provider"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->addDefaultProvider(DefaultProvider::class)->render(),
            ),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        $instance = TagInline::tag();

        self::assertEquals(
            <<<HTML
            <span></span>
            HTML,
            LineEndingNormalizer::normalize(
                $instance->render(),
            ),
            'Failed asserting that element renders correctly with default values.',
        );
    }

    public function testRenderWithDir(): void
    {
        self::assertEquals(
            <<<HTML
            <span dir="rtl"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->dir('rtl')->render(),
            ),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDirUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <span dir="rtl"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->dir(Direction::RTL)->render(),
            ),
            "Failed asserting that element renders correctly with 'dir' attribute using enum.",
        );
    }

    public function testRenderWithDraggable(): void
    {
        self::assertEquals(
            <<<HTML
            <span draggable="true"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->draggable(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'draggable' attribute.",
        );
    }

    public function testRenderWithDraggableUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <span draggable="true"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->draggable(Draggable::TRUE)->render(),
            ),
            "Failed asserting that element renders correctly with 'draggable' attribute using enum.",
        );
    }

    public function testRenderWithGlobalDefaultsAreApplied(): void
    {
        $previous = SimpleFactory::getDefaults(TagInline::class);

        try {
            SimpleFactory::setDefaults(TagInline::class, ['class' => 'from-global']);

            self::assertEquals(
                <<<HTML
                <span class="from-global"></span>
                HTML,
                LineEndingNormalizer::normalize(
                    TagInline::tag()->render(),
                ),
                'Failed asserting that global defaults are applied correctly.',
            );
        } finally {
            SimpleFactory::setDefaults(TagInline::class, $previous);
        }
    }

    public function testRenderWithHidden(): void
    {
        self::assertEquals(
            <<<HTML
            <span hidden></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->hidden(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::assertEquals(
            <<<HTML
            <span id="test-id"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->id('test-id')->render(),
            ),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithItemId(): void
    {
        self::assertEquals(
            <<<HTML
            <span itemid="http://example.com/item"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->itemId('http://example.com/item')->render(),
            ),
            "Failed asserting that element renders correctly with 'itemId' attribute.",
        );
    }

    public function testRenderWithItemProp(): void
    {
        self::assertEquals(
            <<<HTML
            <span itemprop="name"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->itemProp('name')->render(),
            ),
            "Failed asserting that element renders correctly with 'itemProp' attribute.",
        );
    }

    public function testRenderWithItemRef(): void
    {
        self::assertEquals(
            <<<HTML
            <span itemref="additional-info"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->itemRef('additional-info')->render(),
            ),
            "Failed asserting that element renders correctly with 'itemRef' attribute.",
        );
    }

    public function testRenderWithItemScope(): void
    {
        self::assertEquals(
            <<<HTML
            <span itemscope></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->itemScope(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'itemScope' attribute.",
        );
    }

    public function testRenderWithItemType(): void
    {
        self::assertEquals(
            <<<HTML
            <span itemtype="http://schema.org/Person"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->itemType('http://schema.org/Person')->render(),
            ),
            "Failed asserting that element renders correctly with 'itemType' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::assertEquals(
            <<<HTML
            <span lang="es"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->lang('es')->render(),
            ),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithLangUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <span lang="es"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->lang(Language::SPANISH)->render(),
            ),
            "Failed asserting that element renders correctly with 'lang' attribute using enum.",
        );
    }

    public function testRenderWithPrefixAndSuffix(): void
    {
        self::assertEquals(
            <<<HTML
            <strong>Prefix</strong>
            <span>Content</span>
            <em>Suffix</em>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()
                    ->content('Content')
                    ->prefix('Prefix')
                    ->prefixTag(Inline::STRONG)
                    ->suffix('Suffix')
                    ->suffixTag(Inline::EM)
                    ->render(),
            ),
            "Failed asserting that element renders correctly with both 'prefix()' and 'suffix()' methods.",
        );
    }

    public function testRenderWithPrefixSetWithoutPrefixTag(): void
    {
        self::assertEquals(
            <<<HTML
            Prefix content
            <span class="test"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->class('test')->prefix('Prefix content')->render(),
            ),
            "Failed asserting that element renders correctly with 'prefix()' method.",
        );
    }

    public function testRenderWithPrefixTagWhenPrefixSet(): void
    {
        self::assertEquals(
            <<<HTML
            <strong class="prefix-class" id="prefix-id">Prefix content</strong>
            <span></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->prefix('Prefix content')
                    ->prefixAttributes(['id' => 'prefix-id'])
                    ->prefixClass('prefix-class')
                    ->prefixTag(Inline::STRONG)
                    ->render(),
            ),
            "Failed asserting that element renders correctly with 'prefixTag()' method.",
        );
    }

    public function testRenderWithRole(): void
    {
        self::assertEquals(
            <<<HTML
            <span role="button"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->role('button')->render(),
            ),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithRoleUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <span role="button"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->role(Role::BUTTON)->render(),
            ),
            "Failed asserting that element renders correctly with 'role' attribute using enum.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::assertEquals(
            <<<HTML
            <span style='test-value'></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->style('test-value')->render(),
            ),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithSuffixSetWithoutSuffixTag(): void
    {
        self::assertEquals(
            <<<HTML
            <span class="test"></span>
            Suffix content
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->class('test')->suffix('Suffix content')->render(),
            ),
            "Failed asserting that element renders correctly with 'suffix()' method.",
        );
    }

    public function testRenderWithSuffixTagWhenSuffixSet(): void
    {
        self::assertEquals(
            <<<HTML
            <span></span>
            <strong class="suffix-class" id="suffix-id">Suffix content</strong>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()
                    ->suffix('Suffix content')
                    ->suffixAttributes(['id' => 'suffix-id'])
                    ->suffixClass('suffix-class')
                    ->suffixTag(Inline::STRONG)
                    ->render(),
            ),
            "Failed asserting that element renders correctly with 'suffixTag()' method.",
        );
    }

    public function testRenderWithTabindex(): void
    {
        self::assertEquals(
            <<<HTML
            <span tabindex="3"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->tabIndex(3)->render(),
            ),
            "Failed asserting that element renders correctly with 'tabindex' attribute.",
        );
    }

    public function testRenderWithThemeProvider(): void
    {
        self::assertEquals(
            <<<HTML
            <span class="text-muted"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->addThemeProvider('muted', DefaultThemeProvider::class)->render(),
            ),
            'Failed asserting that theme provider is applied correctly.',
        );
    }

    public function testRenderWithTitle(): void
    {
        self::assertEquals(
            <<<HTML
            <span title="test-value"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->title('test-value')->render(),
            ),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithToString(): void
    {
        self::assertEquals(
            <<<HTML
            <span></span>
            HTML,
            LineEndingNormalizer::normalize(
                (string) TagInline::tag(),
            ),
            "Failed asserting that '__toString()' method renders correctly.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::assertEquals(
            <<<HTML
            <span translate="no"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->translate('no')->render(),
            ),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithTranslateUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <span translate="no"></span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInline::tag()->translate(Translate::NO)->render(),
            ),
            "Failed asserting that element renders correctly with 'translate' attribute using enum.",
        );
    }

    public function testRenderWithUserOverridesGlobalDefaults(): void
    {
        $previous = SimpleFactory::getDefaults(TagInline::class);

        try {
            SimpleFactory::setDefaults(TagInline::class, ['class' => 'from-global', 'id' => 'id-global']);

            self::assertEquals(
                <<<HTML
                <span class="from-global" id="id-user"></span>
                HTML,
                LineEndingNormalizer::normalize(
                    TagInline::tag()->id('id-user')->render(),
                ),
                'Failed asserting that user-defined attributes override global defaults correctly.',
            );
        } finally {
            SimpleFactory::setDefaults(TagInline::class, $previous);
        }
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
