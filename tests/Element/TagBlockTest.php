<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use LogicException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use UIAwesome\Html\Core\Element\BaseBlock;
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tag\Block;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, DefaultThemeProvider, TagBlock, TagInline};
use UIAwesome\Html\Core\Tests\Support\TestSupport;
use UIAwesome\Html\Core\Values\{Aria, ContentEditable, DataProperty, Direction, Draggable};

use function get_class;

/**
 * Test suite for {@see TagBlock} element functionality and behavior.
 *
 * Validates the management and rendering of the HTML block element according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the block tag rendering, supporting all global HTML
 * attributes, content, and provider-based configuration.
 *
 * Test coverage.
 * - Accurate rendering of attributes and content for the block element.
 * - Application of default and theme providers.
 * - Data provider-driven validation for edge cases and expected behaviors.
 * - Immutability of the API when setting or overriding attributes.
 * - Nested rendering using `begin()` and `end()` methods.
 * - Precedence of user-defined attributes over global defaults.
 * - Proper assignment and overriding of attribute values, including `accesskey`, `aria-*`, `class`, `data-*`, `dir`,
 *   `id`, `lang`, `role`, `style`, `title`, and `translate`.
 * - Stack integrity during nested `begin()` and `end()` calls.
 *
 * {@see DefaultProvider} for default provider implementation.
 * {@see DefaultThemeProvider} for theme provider implementation.
 * {@see SimpleFactory} for default configuration management.
 * {@see TagBlock} for element implementation details.
 * {@see TestSupport} for assertion utilities.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('element')]
final class TagBlockTest extends TestCase
{
    use TestSupport;

    public function testRenderWithAccesskey(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div accesskey="k">
            </div>
            HTML,
            TagBlock::tag()->accesskey('k')->render(),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div aria-pressed="true">
            </div>
            HTML,
            TagBlock::tag()->addAriaAttribute('pressed', true)->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div aria-pressed="true">
            </div>
            HTML,
            TagBlock::tag()->addAriaAttribute(Aria::PRESSED, true)->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttribute(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div data-value="value">
            </div>
            HTML,
            TagBlock::tag()->addDataAttribute('value', 'value')->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderAddDataAttributeUsingEnum(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div data-value="value">
            </div>
            HTML,
            TagBlock::tag()->addDataAttribute(DataProperty::VALUE, 'value')->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAriaAttributes(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div aria-controls="modal-1" aria-hidden="false" aria-label="Close">
            </div>
            HTML,
            TagBlock::tag()->ariaAttributes(
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
            <div class="test-class">
            </div>
            HTML,
            TagBlock::tag()->attributes(['class' => 'test-class'])->render(),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithAutofocus(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div autofocus>
            </div>
            HTML,
            TagBlock::tag()->autofocus(true)->render(),
            "Failed asserting that element renders correctly with 'autofocus' attribute.",
        );
    }

    public function testRenderWithBeginEnd(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div>
            Content
            </div>
            HTML,
            TagBlock::tag()->begin() . 'Content' . TagBlock::end(),
            "Failed asserting that element renders correctly with 'begin()' and 'end()' methods.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div class="test-class">
            </div>
            HTML,
            TagBlock::tag()->class('test-class')->render(),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithContent(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div>
            Content
            </div>
            HTML,
            TagBlock::tag()->content('Content')->render(),
            "Failed asserting that element renders correctly with 'content()' method.",
        );
    }

    public function testRenderWithContentEditable(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div contenteditable="true">
            </div>
            HTML,
            TagBlock::tag()->contentEditable(ContentEditable::TRUE)->render(),
            "Failed asserting that element renders correctly with 'contentEditable' attribute.",
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div data-value="test-value">
            </div>
            HTML,
            TagBlock::tag()->dataAttributes(['value' => 'test-value'])->render(),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationValues(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div class="default-class" title="default-title">
            </div>
            HTML,
            TagBlock::tag(['class' => 'default-class', 'title' => 'default-title'])->render(),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div class="default-provider">
            </div>
            HTML,
            TagBlock::tag()->addDefaultProvider(DefaultProvider::class)->render(),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        $instance = TagBlock::tag();

        self::equalsWithoutLE(
            <<<HTML
            <div>
            </div>
            HTML,
            $instance->render(),
            'Failed asserting that element renders correctly with default values.',
        );
    }

    public function testRenderWithDir(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div dir="rtl">
            </div>
            HTML,
            TagBlock::tag()->dir(Direction::RTL)->render(),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDraggable(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div draggable="true">
            </div>
            HTML,
            TagBlock::tag()->draggable(Draggable::TRUE)->render(),
            "Failed asserting that element renders correctly with 'draggable' attribute.",
        );
    }

    public function testRenderWithGlobalDefaultsAreApplied(): void
    {
        SimpleFactory::setDefaults(TagBlock::class, ['class' => 'from-global']);

        self::equalsWithoutLE(
            <<<HTML
            <div class="from-global">
            </div>
            HTML,
            TagBlock::tag()->render(),
            'Failed asserting that global defaults are applied correctly.',
        );

        SimpleFactory::setDefaults(TagBlock::class, []);
    }

    public function testRenderWithHidden(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div hidden>
            </div>
            HTML,
            TagBlock::tag()->hidden(true)->render(),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div id="test-id">
            </div>
            HTML,
            TagBlock::tag()->id('test-id')->render(),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithItemId(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div itemid="http://example.com/item">
            </div>
            HTML,
            TagBlock::tag()->itemId('http://example.com/item')->render(),
            "Failed asserting that element renders correctly with 'itemId' attribute.",
        );
    }

    public function testRenderWithItemProp(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div itemprop="name">
            </div>
            HTML,
            TagBlock::tag()->itemProp('name')->render(),
            "Failed asserting that element renders correctly with 'itemProp' attribute.",
        );
    }

    public function testRenderWithItemRef(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div itemref="additional-info">
            </div>
            HTML,
            TagBlock::tag()->itemRef('additional-info')->render(),
            "Failed asserting that element renders correctly with 'itemRef' attribute.",
        );
    }

    public function testRenderWithItemScope(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div itemscope>
            </div>
            HTML,
            TagBlock::tag()->itemScope(true)->render(),
            "Failed asserting that element renders correctly with 'itemScope' attribute.",
        );
    }

    public function testRenderWithItemType(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div itemtype="http://schema.org/Person">
            </div>
            HTML,
            TagBlock::tag()->itemType('http://schema.org/Person')->render(),
            "Failed asserting that element renders correctly with 'itemType' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div lang="es">
            </div>
            HTML,
            TagBlock::tag()->lang('es')->render(),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithNestedBeginEnd(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div>
            <div>
            Nested Content
            </div>
            </div>
            HTML,
            TagBlock::tag()->begin() . TagBlock::tag()->begin() . 'Nested Content' . TagBlock::end() . TagBlock::end(),
            "Failed asserting that nested elements render correctly with 'begin()' and 'end()' methods.",
        );
    }

    public function testRenderWithNestedDifferentTagsEnsuresStackUpdate(): void
    {
        $html = TagBlock::tag()->begin() . TagInline::tag()->content('Content')->render() . TagBlock::end();

        self::equalsWithoutLE(
            <<<HTML
            <div>
            <span>Content</span>
            </div>
            HTML,
            $html,
            'Failed asserting that nested different tags render correctly and stack is updated.',
        );
    }

    public function testRenderWithRole(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div role="banner">
            </div>
            HTML,
            TagBlock::tag()->role('banner')->render(),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithSpellcheck(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div spellcheck="true">
            </div>
            HTML,
            TagBlock::tag()->spellcheck(true)->render(),
            "Failed asserting that element renders correctly with 'spellcheck' attribute.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div style="test-value">
            </div>
            HTML,
            TagBlock::tag()->style('test-value')->render(),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithTabindex(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div tabindex="3">
            </div>
            HTML,
            TagBlock::tag()->tabIndex(3)->render(),
            "Failed asserting that element renders correctly with 'tabindex' attribute.",
        );
    }

    public function testRenderWithThemeProvider(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div class="tag-primary">
            </div>
            HTML,
            TagBlock::tag()->addThemeProvider('primary', DefaultThemeProvider::class)->render(),
            'Failed asserting that theme provider is applied correctly.',
        );
    }

    public function testRenderWithTitle(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div title="test-value">
            </div>
            HTML,
            TagBlock::tag()->title('test-value')->render(),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithToString(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div>
            </div>
            HTML,
            (string) TagBlock::tag(),
            "Failed asserting that '__toString()' method renders correctly.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <div translate="no">
            </div>
            HTML,
            TagBlock::tag()->translate(false)->render(),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithUserOverridesGlobalDefaults(): void
    {
        SimpleFactory::setDefaults(TagBlock::class, ['class' => 'from-global', 'id' => 'id-global']);

        self::equalsWithoutLE(
            <<<HTML
            <div class="from-global" id="id-user">
            </div>
            HTML,
            TagBlock::tag(['id' => 'id-user'])->render(),
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

    public function testThrowExceptionWhenEndWithMismatchedTag(): void
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

    public function testThrowExceptionWhenEndWithoutBegin(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            Message::UNEXPECTED_END_CALL_NO_BEGIN->getMessage(TagBlock::class),
        );

        TagBlock::end();
    }
}
