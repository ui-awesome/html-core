<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use LogicException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tag\Inline;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, DefaultThemeProvider, TagInline};
use UIAwesome\Html\Core\Tests\Support\TestSupport;
use UIAwesome\Html\Core\Values\{Aria, ContentEditable, DataProperty, Direction, Draggable, Language, Role, Translate};

/**
 * Test suite for {@see TagInline} element functionality and behavior.
 *
 * Validates the management and rendering of the HTML inline element according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the inline tag rendering, supporting all global HTML
 * attributes, content, prefix, suffix, and provider-based configuration.
 *
 * Test coverage.
 * - Accurate rendering of attributes and content for the inline element.
 * - Application of default and theme providers.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the API when setting or overriding attributes.
 * - Precedence of user-defined attributes over global defaults.
 * - Proper assignment and overriding of attribute values, including `accesskey`, `aria-*`, `class`, `data-*`, `dir`,
 *  `id`, `lang`, `role`, `style`, `title`, and `translate`.
 * - Rendering with prefix and suffix content, with and without tag wrappers.
 *
 * {@see DefaultProvider} for default provider implementation.
 * {@see DefaultThemeProvider} for theme provider implementation.
 * {@see SimpleFactory} for default configuration management.
 * {@see TagInline} for element implementation details.
 * {@see TestSupport} for assertion utilities.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('element')]
final class TagInlineTest extends TestCase
{
    use TestSupport;

    public function testRenderWithAccesskey(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span accesskey="k"></span>
            HTML,
            TagInline::tag()->accesskey('k')->render(),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span aria-pressed="true"></span>
            HTML,
            TagInline::tag()->addAriaAttribute('pressed', true)->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span aria-pressed="true"></span>
            HTML,
            TagInline::tag()->addAriaAttribute(Aria::PRESSED, true)->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddDataAttribute(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span data-value="value"></span>
            HTML,
            TagInline::tag()->addDataAttribute('value', 'value')->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttributeUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span data-value="value"></span>
            HTML,
            TagInline::tag()->addDataAttribute(DataProperty::VALUE, 'value')->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method using enum.",
        );
    }

    public function testRenderWithAriaAttribute(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span aria-controls="modal-1" aria-hidden="false" aria-label="Close"></span>
            HTML,
            TagInline::tag()->ariaAttributes(
                [
                    'controls' => static fn(): string => 'modal-1',
                    'hidden' => false,
                    'label' => 'Close',
                ],
            )->render(),
            "Failed asserting that element renders correctly with 'ariaAttributes()' method.",
        );
    }

    public function testRenderWithAttributes(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span class="test-class"></span>
            HTML,
            TagInline::tag()->attributes(['class' => 'test-class'])->render(),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span class="test-class"></span>
            HTML,
            TagInline::tag()->class('test-class')->render(),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithContent(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span>Content</span>
            HTML,
            TagInline::tag()->content('Content')->render(),
            "Failed asserting that element renders correctly with 'content()' method.",
        );
    }

    public function testRenderWithContentEditable(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span contenteditable="true"></span>
            HTML,
            TagInline::tag()->contentEditable(true)->render(),
            "Failed asserting that element renders correctly with 'contentEditable' attribute.",
        );
    }

    public function testRenderWithContentEditableUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span contenteditable="true"></span>
            HTML,
            TagInline::tag()->contentEditable(ContentEditable::TRUE)->render(),
            "Failed asserting that element renders correctly with 'contentEditable' attribute using enum.",
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span data-value="test-value"></span>
            HTML,
            TagInline::tag()->dataAttributes(['value' => 'test-value'])->render(),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationMethodValues(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span class="default-class" title="default-title"></span>
            HTML,
            TagInline::tag(['class' => 'default-class', 'title' => 'default-title'])->render(),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span class="default-provider"></span>
            HTML,
            TagInline::tag()->addDefaultProvider(DefaultProvider::class)->render(),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        $instance = TagInline::tag();

        self::equalsWithoutLE(
            <<<HTML
            <span></span>
            HTML,
            $instance->render(),
            'Failed asserting that element renders correctly with default values.',
        );
    }

    public function testRenderWithDir(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span dir="rtl"></span>
            HTML,
            TagInline::tag()->dir('rtl')->render(),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDirUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span dir="rtl"></span>
            HTML,
            TagInline::tag()->dir(Direction::RTL)->render(),
            "Failed asserting that element renders correctly with 'dir' attribute using enum.",
        );
    }

    public function testRenderWithDraggable(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span draggable="true"></span>
            HTML,
            TagInline::tag()->draggable(true)->render(),
            "Failed asserting that element renders correctly with 'draggable' attribute.",
        );
    }

    public function testRenderWithDraggableUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span draggable="true"></span>
            HTML,
            TagInline::tag()->draggable(Draggable::TRUE)->render(),
            "Failed asserting that element renders correctly with 'draggable' attribute using enum.",
        );
    }

    public function testRenderWithGlobalDefaultsAreApplied(): void
    {
        $previous = SimpleFactory::getDefaults(TagInline::class);

        try {
            SimpleFactory::setDefaults(TagInline::class, ['class' => 'from-global']);

            self::equalsWithoutLE(
                <<<HTML
                <span class="from-global"></span>
                HTML,
                TagInline::tag()->render(),
                'Failed asserting that global defaults are applied correctly.',
            );
        } finally {
            SimpleFactory::setDefaults(TagInline::class, $previous);
        }
    }

    public function testRenderWithHidden(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span hidden></span>
            HTML,
            TagInline::tag()->hidden(true)->render(),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span id="test-id"></span>
            HTML,
            TagInline::tag()->id('test-id')->render(),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithItemId(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span itemid="http://example.com/item"></span>
            HTML,
            TagInline::tag()->itemId('http://example.com/item')->render(),
            "Failed asserting that element renders correctly with 'itemId' attribute.",
        );
    }

    public function testRenderWithItemProp(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span itemprop="name"></span>
            HTML,
            TagInline::tag()->itemProp('name')->render(),
            "Failed asserting that element renders correctly with 'itemProp' attribute.",
        );
    }

    public function testRenderWithItemRef(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span itemref="additional-info"></span>
            HTML,
            TagInline::tag()->itemRef('additional-info')->render(),
            "Failed asserting that element renders correctly with 'itemRef' attribute.",
        );
    }

    public function testRenderWithItemScope(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span itemscope></span>
            HTML,
            TagInline::tag()->itemScope(true)->render(),
            "Failed asserting that element renders correctly with 'itemScope' attribute.",
        );
    }

    public function testRenderWithItemType(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span itemtype="http://schema.org/Person"></span>
            HTML,
            TagInline::tag()->itemType('http://schema.org/Person')->render(),
            "Failed asserting that element renders correctly with 'itemType' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span lang="es"></span>
            HTML,
            TagInline::tag()->lang('es')->render(),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithLangUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span lang="es"></span>
            HTML,
            TagInline::tag()->lang(Language::SPANISH)->render(),
            "Failed asserting that element renders correctly with 'lang' attribute using enum.",
        );
    }

    public function testRenderWithPrefixAndSuffix(): void
    {
        self::equalsWithoutLE(
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
        self::equalsWithoutLE(
            <<<HTML
            Prefix content
            <span class="test"></span>
            HTML,
            TagInline::tag()->prefix('Prefix content')->class('test')->render(),
            "Failed asserting that element renders correctly with 'prefix()' method.",
        );
    }

    public function testRenderWithPrefixTagWhenPrefixSet(): void
    {
        self::equalsWithoutLE(
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
        self::equalsWithoutLE(
            <<<HTML
            <span role="button"></span>
            HTML,
            TagInline::tag()->role('button')->render(),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithRoleUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span role="button"></span>
            HTML,
            TagInline::tag()->role(Role::BUTTON)->render(),
            "Failed asserting that element renders correctly with 'role' attribute using enum.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span style="test-value"></span>
            HTML,
            TagInline::tag()->style('test-value')->render(),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithSuffixSetWithoutSuffixTag(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span class="test"></span>
            Suffix content
            HTML,
            TagInline::tag()->class('test')->suffix('Suffix content')->render(),
            "Failed asserting that element renders correctly with 'suffix()' method.",
        );
    }

    public function testRenderWithSuffixTagWhenSuffixSet(): void
    {
        self::equalsWithoutLE(
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
        self::equalsWithoutLE(
            <<<HTML
            <span tabindex="3"></span>
            HTML,
            TagInline::tag()->tabIndex(3)->render(),
            "Failed asserting that element renders correctly with 'tabindex' attribute.",
        );
    }

    public function testRenderWithThemeProvider(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span class="text-muted"></span>
            HTML,
            TagInline::tag()->addThemeProvider('muted', DefaultThemeProvider::class)->render(),
            'Failed asserting that theme provider is applied correctly.',
        );
    }

    public function testRenderWithTitle(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span title="test-value"></span>
            HTML,
            TagInline::tag()->title('test-value')->render(),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithToString(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span></span>
            HTML,
            (string) TagInline::tag(),
            "Failed asserting that '__toString()' method renders correctly.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span translate="no"></span>
            HTML,
            TagInline::tag()->translate(false)->render(),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithTranslateUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <span translate="no"></span>
            HTML,
            TagInline::tag()->translate(Translate::NO)->render(),
            "Failed asserting that element renders correctly with 'translate' attribute using enum.",
        );
    }

    public function testRenderWithUserOverridesGlobalDefaults(): void
    {
        $previous = SimpleFactory::getDefaults(TagInline::class);

        try {
            SimpleFactory::setDefaults(TagInline::class, ['class' => 'from-global', 'id' => 'id-global']);

            self::equalsWithoutLE(
                <<<HTML
                <span class="from-global" id="id-user"></span>
                HTML,
                TagInline::tag(['id' => 'id-user'])->render(),
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
