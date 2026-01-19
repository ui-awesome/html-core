<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use LogicException;
use PHPForge\Support\LineEndingNormalizer;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use UIAwesome\Html\Attribute\Values\{Aria, ContentEditable, Data, Direction, Draggable, Language, Role, Translate};
use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, DefaultThemeProvider, TagBlock, TagInline};
use UIAwesome\Html\Interop\Block;

use function get_class;

/**
 * Unit tests for {@see TagBlock} element rendering and attribute handling.
 *
 * Verifies rendered output, provider application, and `begin()`/`end()` stack behavior for {@see TagBlock}.
 *
 * Test coverage.
 * - Applies default and theme providers.
 * - Renders block elements with representative global HTML attributes.
 * - Supports nested rendering via `begin()` and `end()` with stack integrity.
 * - Throws exceptions for invalid `begin()`/`end()` usage.
 * - Uses `SimpleFactory` defaults while preserving user overrides.
 *
 * {@see TagBlock} for element implementation details.
 * {@see DefaultProvider} for default provider implementation.
 * {@see DefaultThemeProvider} for theme provider implementation.
 * {@see SimpleFactory} for default configuration management.
 * {@see TestSupport} for assertion utilities.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('element')]
final class TagBlockTest extends TestCase
{
    public function testRenderWithAccesskey(): void
    {
        self::assertEquals(
            <<<HTML
            <div accesskey="k">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->accesskey('k')->render(),
            ),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::assertEquals(
            <<<HTML
            <div aria-pressed="true">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->addAriaAttribute('pressed', true)->render(),
            ),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <div aria-pressed="true">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->addAriaAttribute(Aria::PRESSED, true)->render(),
            ),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttribute(): void
    {
        self::assertEquals(
            <<<HTML
            <div data-value="value">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->addDataAttribute('value', 'value')->render(),
            ),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttributeUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <div data-value="value">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->addDataAttribute(Data::VALUE, 'value')->render(),
            ),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAriaAttributes(): void
    {
        self::assertEquals(
            <<<HTML
            <div aria-controls="modal-1" aria-hidden="false" aria-label="Close">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->ariaAttributes(
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
            <div class="test-class">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->attributes(['class' => 'test-class'])->render(),
            ),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithAutofocus(): void
    {
        self::assertEquals(
            <<<HTML
            <div autofocus>
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->autofocus(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'autofocus' attribute.",
        );
    }

    public function testRenderWithBeginEnd(): void
    {
        self::assertEquals(
            <<<HTML
            <div>
            Content
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->begin() . 'Content' . TagBlock::end(),
            ),
            "Failed asserting that element renders correctly with 'begin()' and 'end()' methods.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::assertEquals(
            <<<HTML
            <div class="test-class">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->class('test-class')->render(),
            ),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithContent(): void
    {
        self::assertEquals(
            <<<HTML
            <div>
            Content
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->content('Content')->render(),
            ),
            "Failed asserting that element renders correctly with 'content()' method.",
        );
    }

    public function testRenderWithContentEditable(): void
    {
        self::assertEquals(
            <<<HTML
            <div contenteditable="true">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->contentEditable(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'contentEditable' attribute.",
        );
    }

    public function testRenderWithContentEditableUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <div contenteditable="true">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->contentEditable(ContentEditable::TRUE)->render(),
            ),
            "Failed asserting that element renders correctly with 'contentEditable' attribute using enum.",
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::assertEquals(
            <<<HTML
            <div data-value="test-value">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->dataAttributes(['value' => 'test-value'])->render(),
            ),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationValues(): void
    {
        self::assertEquals(
            <<<HTML
            <div class="default-class" title="default-title">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag(['class' => 'default-class', 'title' => 'default-title'])->render(),
            ),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::assertEquals(
            <<<HTML
            <div class="default-provider">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->addDefaultProvider(DefaultProvider::class)->render(),
            ),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        $instance = TagBlock::tag();

        self::assertEquals(
            <<<HTML
            <div>
            </div>
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
            <div dir="rtl">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->dir('rtl')->render(),
            ),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDirUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <div dir="rtl">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->dir(Direction::RTL)->render(),
            ),
            "Failed asserting that element renders correctly with 'dir' attribute using enum.",
        );
    }

    public function testRenderWithDraggable(): void
    {
        self::assertEquals(
            <<<HTML
            <div draggable="true">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->draggable(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'draggable' attribute.",
        );
    }

    public function testRenderWithDraggableUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <div draggable="true">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->draggable(Draggable::TRUE)->render(),
            ),
            "Failed asserting that element renders correctly with 'draggable' attribute using enum.",
        );
    }

    public function testRenderWithGlobalDefaultsAreApplied(): void
    {
        SimpleFactory::setDefaults(TagBlock::class, ['class' => 'from-global']);

        self::assertEquals(
            <<<HTML
            <div class="from-global">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->render(),
            ),
            'Failed asserting that global defaults are applied correctly.',
        );

        SimpleFactory::setDefaults(TagBlock::class, []);
    }

    public function testRenderWithHidden(): void
    {
        self::assertEquals(
            <<<HTML
            <div hidden>
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->hidden(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::assertEquals(
            <<<HTML
            <div id="test-id">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->id('test-id')->render(),
            ),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithItemId(): void
    {
        self::assertEquals(
            <<<HTML
            <div itemid="http://example.com/item">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->itemId('http://example.com/item')->render(),
            ),
            "Failed asserting that element renders correctly with 'itemId' attribute.",
        );
    }

    public function testRenderWithItemProp(): void
    {
        self::assertEquals(
            <<<HTML
            <div itemprop="name">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->itemProp('name')->render(),
            ),
            "Failed asserting that element renders correctly with 'itemProp' attribute.",
        );
    }

    public function testRenderWithItemRef(): void
    {
        self::assertEquals(
            <<<HTML
            <div itemref="additional-info">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->itemRef('additional-info')->render(),
            ),
            "Failed asserting that element renders correctly with 'itemRef' attribute.",
        );
    }

    public function testRenderWithItemScope(): void
    {
        self::assertEquals(
            <<<HTML
            <div itemscope>
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->itemScope(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'itemScope' attribute.",
        );
    }

    public function testRenderWithItemType(): void
    {
        self::assertEquals(
            <<<HTML
            <div itemtype="http://schema.org/Person">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->itemType('http://schema.org/Person')->render(),
            ),
            "Failed asserting that element renders correctly with 'itemType' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::assertEquals(
            <<<HTML
            <div lang="es">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->lang('es')->render(),
            ),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithLangUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <div lang="es">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->lang(Language::SPANISH)->render(),
            ),
            "Failed asserting that element renders correctly with 'lang' attribute using enum.",
        );
    }

    public function testRenderWithNestedBeginEnd(): void
    {
        self::assertEquals(
            <<<HTML
            <div>
            <div>
            Nested Content
            </div>
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->begin() . TagBlock::tag()->begin() . 'Nested Content' . TagBlock::end() . TagBlock::end(),
            ),
            "Failed asserting that nested elements render correctly with 'begin()' and 'end()' methods.",
        );
    }

    public function testRenderWithNestedDifferentTagsEnsuresStackUpdate(): void
    {
        $html = TagBlock::tag()->begin() . TagInline::tag()->content('Content')->render() . TagBlock::end();

        self::assertEquals(
            <<<HTML
            <div>
            <span>Content</span>
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                $html,
            ),
            'Failed asserting that nested different tags render correctly and stack is updated.',
        );
    }

    public function testRenderWithRole(): void
    {
        self::assertEquals(
            <<<HTML
            <div role="banner">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->role('banner')->render(),
            ),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithRoleUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <div role="banner">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->role(Role::BANNER)->render(),
            ),
            "Failed asserting that element renders correctly with 'role' attribute using enum.",
        );
    }

    public function testRenderWithSpellcheck(): void
    {
        self::assertEquals(
            <<<HTML
            <div spellcheck="true">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->spellcheck(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'spellcheck' attribute.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::assertEquals(
            <<<HTML
            <div style='test-value'>
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->style('test-value')->render(),
            ),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithTabindex(): void
    {
        self::assertEquals(
            <<<HTML
            <div tabindex="3">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->tabIndex(3)->render(),
            ),
            "Failed asserting that element renders correctly with 'tabindex' attribute.",
        );
    }

    public function testRenderWithThemeProvider(): void
    {
        self::assertEquals(
            <<<HTML
            <div class="tag-primary">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->addThemeProvider('primary', DefaultThemeProvider::class)->render(),
            ),
            'Failed asserting that theme provider is applied correctly.',
        );
    }

    public function testRenderWithTitle(): void
    {
        self::assertEquals(
            <<<HTML
            <div title="test-value">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->title('test-value')->render(),
            ),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithToString(): void
    {
        self::assertEquals(
            <<<HTML
            <div>
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                (string) TagBlock::tag(),
            ),
            "Failed asserting that '__toString()' method renders correctly.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::assertEquals(
            <<<HTML
            <div translate="no">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->translate(false)->render(),
            ),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithTranslateUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <div translate="yes">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag()->translate(Translate::YES)->render(),
            ),
            "Failed asserting that element renders correctly with 'translate' attribute using enum.",
        );
    }

    public function testRenderWithUserOverridesGlobalDefaults(): void
    {
        SimpleFactory::setDefaults(TagBlock::class, ['class' => 'from-global', 'id' => 'id-global']);

        self::assertEquals(
            <<<HTML
            <div class="from-global" id="id-user">
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagBlock::tag(['id' => 'id-user'])->render(),
            ),
            'Failed asserting that user-defined attributes override global defaults correctly.',
        );

        SimpleFactory::setDefaults(TagBlock::class, []);
    }

    public function testReturnEmptyArrayWhenApplyThemeAndUndefinedTheme(): void
    {
        $tag = TagBlock::tag();

        self::assertEmpty(
            $tag->apply($tag, ''),
            'Failed asserting that applying an undefined theme returns an empty array.',
        );
    }

    public function testReturnEmptyArrayWhenGetDefaultsAndNoDefaultsSet(): void
    {
        $tag = TagBlock::tag();

        self::assertEmpty(
            $tag->getDefaults($tag),
            'Failed asserting that getting defaults returns an empty array when no defaults are set.',
        );
    }

    public function testThrowLogicExceptionForEndWithoutBegin(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            Message::UNEXPECTED_END_CALL_NO_BEGIN->getMessage(TagBlock::class),
        );

        TagBlock::end();
    }

    public function testThrowRuntimeExceptionForEndWithMismatchedTag(): void
    {
        $tag = new class extends BaseBlock {
            /**
             * Returns the tag enumeration for the `<article>` element.
             *
             * @return Block Tag enumeration instance for `<article>`.
             */
            protected function getTag(): Block
            {
                return Block::ARTICLE;
            }
        };

        $tagClass = get_class($tag);
        TagBlock::tag()->begin();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            Message::TAG_CLASS_MISMATCH_ON_END->getMessage(TagBlock::class, $tagClass),
        );

        $tag::end();
    }
}
