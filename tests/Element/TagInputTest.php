<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use PHPForge\Support\{LineEndingNormalizer, ReflectionHelper};
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
        self::assertEquals(
            <<<HTML
            <input accesskey="k">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->accesskey('k')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::assertEquals(
            <<<HTML
            <input aria-pressed="true">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->addAriaAttribute('pressed', true)->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <input aria-pressed="true">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->addAriaAttribute(Aria::PRESSED, true)->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddAriaDescribedByString(): void
    {
        self::assertEquals(
            <<<HTML
            <input id="test-id" aria-describedby="custom-help">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', 'custom-help')
                ->id('test-id')
                ->render(),
            "Failed asserting that an explicit 'aria-describedby' string value is preserved.",
        );
    }

    public function testRenderWithAddAriaDescribedByTrue(): void
    {
        self::assertEquals(
            <<<HTML
            <input id="test-id" aria-describedby="test-id-help">
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', true)
                ->id('test-id')
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to true.",
        );
    }

    public function testRenderWithAddAriaDescribedByTrueAndIdNull(): void
    {
        self::assertEquals(
            <<<HTML
            <input>
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', true)
                ->id(null)
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to true and 'id' is null.",
        );
    }

    public function testRenderWithAddAriaDescribedByTrueAndPrefixSuffix(): void
    {
        self::assertEquals(
            <<<HTML
            <span>Prefix</span>
            <input id="test-id" aria-describedby="test-id-help">
            <span>Suffix</span>
            HTML,
            TagInput::tag()
                ->addAriaAttribute('describedby', true)
                ->id('test-id')
                ->prefix('Prefix')
                ->prefixTag(Inline::SPAN)
                ->suffix('Suffix')
                ->suffixTag(Inline::SPAN)
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to true and prefix/suffix.",
        );
    }

    public function testRenderWithAddDataAttribute(): void
    {
        self::assertEquals(
            <<<HTML
            <input data-value="value">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->addDataAttribute('value', 'value')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttributeUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <input data-value="value">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->addDataAttribute(Data::VALUE, 'value')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddEvent(): void
    {
        self::assertEquals(
            <<<HTML
            <input onclick="handleClick()">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->addEvent(Event::CLICK, 'handleClick()')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'addEvent()' method.",
        );
    }

    public function testRenderWithAriaAttributes(): void
    {
        self::assertEquals(
            <<<HTML
            <input aria-label="Close" aria-hidden="false" aria-controls="modal-1">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()
                    ->ariaAttributes(
                        [
                            'label' => 'Close',
                            'hidden' => false,
                            'controls' => static fn(): string => 'modal-1',
                        ],
                    )
                    ->id(null)
                    ->render(),
            ),
            "Failed asserting that element renders correctly with 'ariaAttributes()' method.",
        );
    }

    public function testRenderWithAriaAttributesAndAriaDescribedByTrue(): void
    {
        self::assertEquals(
            <<<HTML
            <input id="test-id" aria-describedby="test-id-help">
            HTML,
            TagInput::tag()
                ->ariaAttributes(['describedby' => true])
                ->id('test-id')
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to true.",
        );
    }

    public function testRenderWithAttributes(): void
    {
        self::assertEquals(
            <<<HTML
            <input class="test-class">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->attributes(['class' => 'test-class'])->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithAttributesAndAriaDescribedByTrue(): void
    {
        self::assertEquals(
            <<<HTML
            <input id="test-id" aria-describedby="test-id-help">
            HTML,
            TagInput::tag()
                ->attributes(['aria-describedby' => true])
                ->id('test-id')
                ->render(),
            "Failed asserting that element renders correctly with 'aria-describedby' attribute set to true.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::assertEquals(
            <<<HTML
            <input class="test-class">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->class('test-class')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithCustomTokenValues(): void
    {
        self::assertEquals(
            <<<HTML
            <input id="test-id">
            <span class="custom-token">Custom content from token</span>
            HTML,
            LineEndingNormalizer::normalize(
                TagInputWithTokenValues::tag()
                    ->id('test-id')
                    ->template('{tag}\n{custom}')
                    ->tokenValues(['{custom}' => '<span class="custom-token">Custom content from token</span>'])
                    ->render(),
            ),
            'Failed asserting that element renders correctly with custom token values spread into template.',
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::assertEquals(
            <<<HTML
            <input data-value="test-value">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->dataAttributes(['value' => 'test-value'])->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationValues(): void
    {
        self::assertEquals(
            <<<HTML
            <input class="default-class" title="default-title">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag(['class' => 'default-class', 'title' => 'default-title'])->id(null)->render(),
            ),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::assertEquals(
            <<<HTML
            <input class="default-provider">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->addDefaultProvider(DefaultProvider::class)->id(null)->render(),
            ),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        $instance = TagInput::tag()->id(null);

        self::assertEquals(
            <<<HTML
            <input>
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
            <input dir="rtl">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->dir('rtl')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDirUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <input dir="ltr">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->dir(Direction::LTR)->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'dir' attribute using enum.",
        );
    }

    public function testRenderWithDisabled(): void
    {
        self::assertEquals(
            <<<HTML
            <input disabled>
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->disabled(true)->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'disabled' attribute.",
        );
    }

    public function testRenderWithEvents(): void
    {
        self::assertEquals(
            <<<HTML
            <input onchange="handleChange()">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->events(['change' => 'handleChange()'])->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'events()' method.",
        );
    }

    public function testRenderWithForm(): void
    {
        self::assertEquals(
            <<<HTML
            <input form="signup-form">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->form('signup-form')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'form' attribute.",
        );
    }

    public function testRenderWithGenerateId(): void
    {
        self::assertStringContainsString(
            'id="taginput-',
            TagInput::tag()->render(),
            "Failed asserting that element generates an 'id' attribute when none is provided.",
        );
    }

    public function testRenderWithGlobalDefaultsAreApplied(): void
    {
        $previous = SimpleFactory::getDefaults(TagInput::class);

        try {
            SimpleFactory::setDefaults(TagInput::class, ['class' => 'from-global']);

            self::assertEquals(
                <<<HTML
                <input class="from-global">
                HTML,
                LineEndingNormalizer::normalize(
                    TagInput::tag()->id(null)->render(),
                ),
                'Failed asserting that global defaults are applied correctly.',
            );
        } finally {
            SimpleFactory::setDefaults(TagInput::class, $previous);
        }
    }

    public function testRenderWithHidden(): void
    {
        self::assertEquals(
            <<<HTML
            <input hidden>
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->hidden(true)->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::assertEquals(
            <<<HTML
            <input id="test-id">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->id('test-id')->render(),
            ),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::assertEquals(
            <<<HTML
            <input lang="es">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->lang('es')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithLangUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <input lang="es">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->lang(Language::SPANISH)->id(null)->render(),
            ),
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
            ['{prefix}\n{tag}\n{suffix}'],
            $defaults['template'] ?? [],
            'Failed asserting that default definitions are applied correctly.',
        );
    }

    public function testRenderWithName(): void
    {
        self::assertEquals(
            <<<HTML
            <input name="username">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->name('username')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'name' attribute.",
        );
    }

    public function testRenderWithPrefixAndSuffix(): void
    {
        self::assertEquals(
            <<<HTML
            <strong>Prefix</strong>
            <input>
            <em>Suffix</em>
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()
                    ->id(null)
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
            <input class="test">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->class('test')->prefix('Prefix content')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'prefix()' method.",
        );
    }

    public function testRenderWithPrefixTagUsingBlockTag(): void
    {
        self::assertEquals(
            <<<HTML
            <div class="prefix-class" id="prefix-id">
            Prefix content
            </div>
            <input>
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()
                    ->prefix('Prefix content')
                    ->prefixAttributes(['id' => 'prefix-id'])
                    ->prefixClass('prefix-class')
                    ->prefixTag(Block::DIV)
                    ->id(null)
                    ->render(),
            ),
            "Failed asserting that element renders correctly with 'prefixTag()' method using a block tag.",
        );
    }

    public function testRenderWithPrefixTagWhenPrefixSet(): void
    {
        self::assertEquals(
            <<<HTML
            <strong class="prefix-class" id="prefix-id">Prefix content</strong>
            <input>
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()
                    ->prefix('Prefix content')
                    ->prefixAttributes(['id' => 'prefix-id'])
                    ->prefixClass('prefix-class')
                    ->prefixTag(Inline::STRONG)
                    ->id(null)
                    ->render(),
            ),
            "Failed asserting that element renders correctly with 'prefixTag()' method.",
        );
    }

    public function testRenderWithRole(): void
    {
        self::assertEquals(
            <<<HTML
            <input role="button">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->role('button')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithRoleUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <input role="button">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->role(Role::BUTTON)->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'role' attribute using enum.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::assertEquals(
            <<<HTML
            <input style='test-value'>
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->style('test-value')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithSuffixSetWithoutSuffixTag(): void
    {
        self::assertEquals(
            <<<HTML
            <input class="test">
            Suffix content
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->class('test')->suffix('Suffix content')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'suffix()' method.",
        );
    }

    public function testRenderWithSuffixTagUsingBlockTag(): void
    {
        self::assertEquals(
            <<<HTML
            <input>
            <div class="suffix-class" id="suffix-id">
            Suffix content
            </div>
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()
                    ->suffix('Suffix content')
                    ->suffixAttributes(['id' => 'suffix-id'])
                    ->suffixClass('suffix-class')
                    ->suffixTag(Block::DIV)
                    ->id(null)
                    ->render(),
            ),
            "Failed asserting that element renders correctly with 'suffixTag()' method using a block tag.",
        );
    }

    public function testRenderWithSuffixTagWhenSuffixSet(): void
    {
        self::assertEquals(
            <<<HTML
            <input>
            <strong class="suffix-class" id="suffix-id">Suffix content</strong>
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()
                    ->suffix('Suffix content')
                    ->suffixAttributes(['id' => 'suffix-id'])
                    ->suffixClass('suffix-class')
                    ->suffixTag(Inline::STRONG)
                    ->id(null)
                    ->render(),
            ),
            "Failed asserting that element renders correctly with 'suffixTag()' method.",
        );
    }

    public function testRenderWithTemplateFallbackWhenTemplateEmpty(): void
    {
        self::assertEquals(
            <<<HTML
            Prefix content
            <input>
            Suffix content
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()
                    ->id(null)
                    ->template('')
                    ->prefix('Prefix content')
                    ->suffix('Suffix content')
                    ->render(),
            ),
            "Failed asserting that element renders correctly when 'template()' is empty.",
        );
    }

    public function testRenderWithTitle(): void
    {
        self::assertEquals(
            <<<HTML
            <input title="test-value">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->title('test-value')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::assertEquals(
            <<<HTML
            <input translate="no">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->translate('no')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithTranslateUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <input translate="yes">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->translate(Translate::YES)->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'translate' attribute using enum.",
        );
    }

    public function testRenderWithType(): void
    {
        self::assertEquals(
            <<<HTML
            <input type="text">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()->type('text')->id(null)->render(),
            ),
            "Failed asserting that element renders correctly with 'type' attribute.",
        );
    }

    public function testRenderWithUserOverridesGlobalDefaults(): void
    {
        $previous = SimpleFactory::getDefaults(TagInput::class);

        try {
            SimpleFactory::setDefaults(TagInput::class, ['class' => 'from-global', 'id' => 'id-global']);

            self::assertEquals(
                <<<HTML
                <input class="from-global" id="id-user">
                HTML,
                LineEndingNormalizer::normalize(
                    TagInput::tag(['id' => 'id-user'])->render(),
                ),
                'Failed asserting that user-defined attributes override global defaults correctly.',
            );
        } finally {
            SimpleFactory::setDefaults(TagInput::class, $previous);
        }
    }

    public function testRenderWithVoidPrefixTag(): void
    {
        self::assertEquals(
            <<<HTML
            <img src="icon.svg" alt="Icon">
            <input>
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()
                    ->id(null)
                    ->prefixAttributes(['src' => 'icon.svg', 'alt' => 'Icon'])
                    ->prefixTag(Voids::IMG)
                    ->render(),
            ),
            'Failed asserting that element renders correctly with a void prefix tag.',
        );
    }

    public function testRenderWithVoidSuffixTag(): void
    {
        self::assertEquals(
            <<<HTML
            <input>
            <img src="icon.svg" alt="Icon">
            HTML,
            LineEndingNormalizer::normalize(
                TagInput::tag()
                    ->id(null)
                    ->suffixAttributes(['src' => 'icon.svg', 'alt' => 'Icon'])
                    ->suffixTag(Voids::IMG)
                    ->render(),
            ),
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
