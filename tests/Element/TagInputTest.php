<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use InvalidArgumentException;
use PHPForge\Support\ReflectionHelper;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Attribute\Values\{Aria, Data, Direction, Event, GlobalAttribute, Language, Role, Translate};
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, TagInput, TagInputWithTokenValues};
use UIAwesome\Html\Helper\Enum;
use UIAwesome\Html\Helper\Exception\Message;
use UIAwesome\Html\Interop\{Block, Inline, Voids};

/**
 * Unit tests for the {@see TagInput} class.
 *
 * Test coverage.
 * - Ensures `aria-describedby` derives from `id` when set to `true` and is omitted when `id` is `null`.
 * - Ensures `ariaDescribedBySuffix()` customizes the suffix appended to `id` for `aria-describedby`.
 * - Ensures default providers and global defaults apply expected attributes, with user overrides preserved.
 * - Verifies input tags render expected HTML for representative global and input-specific attributes.
 * - Verifies prefix and suffix content renders with block, inline, and void wrapper tags.
 * - Verifies template fallback renders prefix, tag, and suffix when `template` is empty.
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
            <input accesskey="value">
            HTML,
            TagInput::tag()
                ->accesskey('value')
                ->render(),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::assertSame(
            <<<HTML
            <input aria-label="value">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('label', 'value')
                ->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input aria-label="value">
            HTML,
            TagInput::tag()
                ->addAriaAttribute(Aria::LABEL, 'value')
                ->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddAriaDescribedByString(): void
    {
        self::assertSame(
            <<<HTML
            <input aria-describedby="value">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', 'value')
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
            <input data-value="value">
            HTML,
            TagInput::tag()
                ->addDataAttribute('value', 'value')
                ->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttributeUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input data-value="value">
            HTML,
            TagInput::tag()
                ->addDataAttribute(Data::VALUE, 'value')
                ->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddEvent(): void
    {
        self::assertSame(
            <<<HTML
            <input onclick="handleClick()">
            HTML,
            TagInput::tag()
                ->addEvent(Event::CLICK, 'handleClick()')
                ->render(),
            "Failed asserting that element renders correctly with 'addEvent()' method.",
        );
    }

    public function testRenderWithAriaAttributes(): void
    {
        self::assertSame(
            <<<HTML
            <input aria-controls="value" aria-label="value">
            HTML,
            TagInput::tag()
                ->ariaAttributes(
                    [
                        'controls' => 'value',
                        'label' => 'value',
                    ],
                )
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

    public function testRenderWithAriaDescribedBySuffix(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-describedby="taginput-hint">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', true)
                ->ariaDescribedBySuffix('-hint')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with a custom 'ariaDescribedBySuffix()' value.",
        );
    }

    public function testRenderWithAriaDescribedBySuffixAndEmptySuffixUsesDefault(): void
    {
        self::assertSame(
            <<<HTML
            <input id="taginput" aria-describedby="taginput-help">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', true)
                ->ariaDescribedBySuffix('')
                ->id('taginput')
                ->render(),
            "Failed asserting that element renders correctly with a custom 'ariaDescribedBySuffix()' value.",
        );
    }

    public function testRenderWithAriaDescribedBySuffixAndIdNull(): void
    {
        self::assertSame(
            <<<HTML
            <input>
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', true)
                ->ariaDescribedBySuffix('-hint')
                ->id(null)
                ->render(),
            "Failed asserting that element renders correctly with a custom 'ariaDescribedBySuffix()' value and 'id' "
            . "is 'null'.",
        );
    }

    public function testRenderWithAttributes(): void
    {
        self::assertSame(
            <<<HTML
            <input class="value">
            HTML,
            TagInput::tag()
                ->attributes(['class' => 'value'])
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
            <input class="value">
            HTML,
            TagInput::tag()
                ->class('value')
                ->render(),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithCustomTokenValues(): void
    {
        self::assertSame(
            <<<HTML
            <input>
            <span class="custom-token">Custom content from token</span>
            HTML,
            TagInputWithTokenValues::tag()
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
            <input data-value="test-value">
            HTML,
            TagInput::tag()
                ->dataAttributes(['value' => 'test-value'])
                ->render(),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationValues(): void
    {
        self::assertSame(
            <<<HTML
            <input class="default-class" title="default-title">
            HTML,
            TagInput::tag(['class' => 'default-class', 'title' => 'default-title'])->render(),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::assertSame(
            <<<HTML
            <input class="default-provider">
            HTML,
            TagInput::tag()
                ->addDefaultProvider(DefaultProvider::class)
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
            TagInput::tag()->render(),
            'Failed asserting that element renders correctly with default values.',
        );
    }

    public function testRenderWithDir(): void
    {
        self::assertSame(
            <<<HTML
            <input dir="rtl">
            HTML,
            TagInput::tag()
                ->dir('rtl')
                ->render(),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDirUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input dir="ltr">
            HTML,
            TagInput::tag()
                ->dir(Direction::LTR)
                ->render(),
            "Failed asserting that element renders correctly with 'dir' attribute using enum.",
        );
    }

    public function testRenderWithDisabled(): void
    {
        self::assertSame(
            <<<HTML
            <input disabled>
            HTML,
            TagInput::tag()
                ->disabled(true)
                ->render(),
            "Failed asserting that element renders correctly with 'disabled' attribute.",
        );
    }

    public function testRenderWithEvents(): void
    {
        self::assertSame(
            <<<HTML
            <input onchange="handleChange()">
            HTML,
            TagInput::tag()
                ->events(['change' => 'handleChange()'])
                ->render(),
            "Failed asserting that element renders correctly with 'events()' method.",
        );
    }

    public function testRenderWithForm(): void
    {
        self::assertSame(
            <<<HTML
            <input form="value">
            HTML,
            TagInput::tag()
                ->form('value')
                ->render(),
            "Failed asserting that element renders correctly with 'form' attribute.",
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
            <input class="from-global">
            HTML,
            TagInput::tag()->render(),
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
            <input hidden>
            HTML,
            TagInput::tag()
                ->hidden(true)
                ->render(),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::assertSame(
            <<<HTML
            <input id="value">
            HTML,
            TagInput::tag()
                ->id('value')
                ->render(),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::assertSame(
            <<<HTML
            <input lang="en">
            HTML,
            TagInput::tag()
                ->lang('en')
                ->render(),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithLangUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input lang="en">
            HTML,
            TagInput::tag()
                ->lang(Language::ENGLISH)
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
            <input name="value">
            HTML,
            TagInput::tag()
                ->name('value')
                ->render(),
            "Failed asserting that element renders correctly with 'name' attribute.",
        );
    }

    public function testRenderWithPrefixAndSuffix(): void
    {
        self::assertSame(
            <<<HTML
            <strong>Prefix</strong>
            <input>
            <em>Suffix</em>
            HTML,
            TagInput::tag()
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
            <input class="value">
            HTML,
            TagInput::tag()
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
            <input>
            HTML,
            TagInput::tag()
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
            <input>
            HTML,
            TagInput::tag()
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
            <input role="button">
            HTML,
            TagInput::tag()
                ->role('button')
                ->render(),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithRoleUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input role="button">
            HTML,
            TagInput::tag()
                ->role(Role::BUTTON)
                ->render(),
            "Failed asserting that element renders correctly with 'role' attribute using enum.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::assertSame(
            <<<HTML
            <input style='value'>
            HTML,
            TagInput::tag()
                ->style('value')
                ->render(),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithSuffixSetWithoutSuffixTag(): void
    {
        self::assertSame(
            <<<HTML
            <input class="value">
            Suffix content
            HTML,
            TagInput::tag()
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
            <input>
            <div class="suffix-class" id="suffix-id">
            Suffix content
            </div>
            HTML,
            TagInput::tag()
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
            <input>
            <strong class="suffix-class" id="suffix-id">Suffix content</strong>
            HTML,
            TagInput::tag()
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
            <input>
            Suffix content
            HTML,
            TagInput::tag()
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
            <input title="value">
            HTML,
            TagInput::tag()
                ->title('value')
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
            <input translate="no">
            HTML,
            TagInput::tag()
                ->translate('no')
                ->render(),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithTranslateUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <input translate="yes">
            HTML,
            TagInput::tag()
                ->translate(Translate::YES)
                ->render(),
            "Failed asserting that element renders correctly with 'translate' attribute using enum.",
        );
    }

    public function testRenderWithType(): void
    {
        self::assertSame(
            <<<HTML
            <input type="text">
            HTML,
            TagInput::tag()
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
            <input class="from-global" id="value">
            HTML,
            TagInput::tag(['id' => 'value'])->render(),
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

    public function testReturnNewInstanceWhenSettingAttribute(): void
    {
        $tagInput = TagInput::tag();

        self::assertNotSame(
            $tagInput,
            $tagInput->ariaDescribedBySuffix(''),
            'Should return a new instance when setting the attribute, ensuring immutability.',
        );
    }

    public function testThrowInvalidArgumentExceptionWhenSettingDir(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                GlobalAttribute::DIR->value,
                implode("', '", Enum::normalizeArray(Direction::cases())),
            ),
        );

        TagInput::tag()->dir('invalid-value');
    }

    public function testThrowInvalidArgumentExceptionWhenSettingLang(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                GlobalAttribute::LANG->value,
                implode("', '", Enum::normalizeArray(Language::cases())),
            ),
        );

        TagInput::tag()->lang('invalid-value');
    }

    public function testThrowInvalidArgumentExceptionWhenSettingRole(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                GlobalAttribute::ROLE->value,
                implode("', '", Enum::normalizeArray(Role::cases())),
            ),
        );

        TagInput::tag()->role('invalid-value');
    }

    public function testThrowInvalidArgumentExceptionWhenSettingTranslate(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            Message::VALUE_NOT_IN_LIST->getMessage(
                'invalid-value',
                GlobalAttribute::TRANSLATE->value,
                implode("', '", Enum::normalizeArray(Translate::cases())),
            ),
        );

        TagInput::tag()->translate('invalid-value');
    }
}
