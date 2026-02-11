<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use PHPForge\Support\ReflectionHelper;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Attribute\Values\{Aria, Data, Direction, Event, Language, Role, Translate};
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, DefaultThemeProvider, TagVoid};

/**
 * Unit tests for the {@see TagVoid} class.
 *
 * Test coverage.
 * - Ensures default and theme providers apply expected attributes.
 * - Ensures global defaults are applied and user attributes override them.
 * - Verifies undefined themes and missing defaults return empty arrays.
 * - Verifies void tags render expected HTML for representative global attributes.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('element')]
final class TagVoidTest extends TestCase
{
    public function testRenderWithAccesskey(): void
    {
        self::assertSame(
            <<<HTML
            <hr accesskey="k">
            HTML,
            TagVoid::tag()
                ->accesskey('k')
                ->render(),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::assertSame(
            <<<HTML
            <hr aria-pressed="true">
            HTML,
            TagVoid::tag()
                ->addAriaAttribute('pressed', true)
                ->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <hr aria-pressed="true">
            HTML,
            TagVoid::tag()
                ->addAriaAttribute(Aria::PRESSED, true)
                ->render(),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddDataAttribute(): void
    {
        self::assertSame(
            <<<HTML
            <hr data-value="value">
            HTML,
            TagVoid::tag()
                ->addDataAttribute('value', 'value')
                ->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttributeUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <hr data-value="value">
            HTML,
            TagVoid::tag()
                ->addDataAttribute(Data::VALUE, 'value')
                ->render(),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddEvent(): void
    {
        self::assertSame(
            <<<HTML
            <hr onclick="handleClick()">
            HTML,
            TagVoid::tag()
                ->addEvent(Event::CLICK, 'handleClick()')
                ->render(),
            "Failed asserting that element renders correctly with 'addEvent()' method.",
        );
    }

    public function testRenderWithAriaAttributes(): void
    {
        self::assertSame(
            <<<HTML
            <hr aria-label="Close" aria-hidden="false" aria-controls="modal-1">
            HTML,
            TagVoid::tag()
                ->ariaAttributes(
                    [
                        'label' => 'Close',
                        'hidden' => false,
                        'controls' => static fn(): string => 'modal-1',
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
            <hr class="test-class">
            HTML,
            TagVoid::tag()
                ->attributes(['class' => 'test-class'])
                ->render(),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::assertSame(
            <<<HTML
            <hr class="test-class">
            HTML,
            TagVoid::tag()
                ->class('test-class')
                ->render(),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::assertSame(
            <<<HTML
            <hr data-value="test-value">
            HTML,
            TagVoid::tag()
                ->dataAttributes(['value' => 'test-value'])
                ->render(),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationValues(): void
    {
        self::assertSame(
            <<<HTML
            <hr class="default-class" title="default-title">
            HTML,
            TagVoid::tag(['class' => 'default-class', 'title' => 'default-title'])->render(),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::assertSame(
            <<<HTML
            <hr class="default-provider">
            HTML,
            TagVoid::tag()
                ->addDefaultProvider(DefaultProvider::class)
                ->render(),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        self::assertSame(
            <<<HTML
            <hr>
            HTML,
            TagVoid::tag()->render(),
            'Failed asserting that element renders correctly with default values.',
        );
    }

    public function testRenderWithDir(): void
    {
        self::assertSame(
            <<<HTML
            <hr dir="rtl">
            HTML,
            TagVoid::tag()
                ->dir('rtl')
                ->render(),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDirUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <hr dir="ltr">
            HTML,
            TagVoid::tag()
                ->dir(Direction::LTR)
                ->render(),
            "Failed asserting that element renders correctly with 'dir' attribute using enum.",
        );
    }

    public function testRenderWithEvents(): void
    {
        self::assertSame(
            <<<HTML
            <hr onchange="handleChange()">
            HTML,
            TagVoid::tag()
                ->events(['change' => 'handleChange()'])
                ->render(),
            "Failed asserting that element renders correctly with 'events()' method.",
        );
    }

    public function testRenderWithGlobalDefaultsAreApplied(): void
    {
        SimpleFactory::setDefaults(
            TagVoid::class,
            ['class' => 'from-global'],
        );

        self::assertSame(
            <<<HTML
            <hr class="from-global">
            HTML,
            TagVoid::tag()->render(),
            'Failed asserting that global defaults are applied correctly.',
        );

        SimpleFactory::setDefaults(
            TagVoid::class,
            [],
        );
    }

    public function testRenderWithHidden(): void
    {
        self::assertSame(
            <<<HTML
            <hr hidden>
            HTML,
            TagVoid::tag()
                ->hidden(true)
                ->render(),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::assertSame(
            <<<HTML
            <hr id="tagvoid">
            HTML,
            TagVoid::tag()
                ->id('tagvoid')
                ->render(),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::assertSame(
            <<<HTML
            <hr lang="es">
            HTML,
            TagVoid::tag()
                ->lang('es')
                ->render(),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithLangUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <hr lang="es">
            HTML,
            TagVoid::tag()
                ->lang(Language::SPANISH)
                ->render(),
            "Failed asserting that element renders correctly with 'lang' attribute using enum.",
        );
    }

    public function testRenderWithLoadDefault(): void
    {
        self::assertEmpty(
            ReflectionHelper::invokeMethod(TagVoid::tag(), 'loadDefault'),
            'Failed asserting that loading default definitions returns an empty array when no defaults are set.',
        );
    }

    public function testRenderWithRole(): void
    {
        self::assertSame(
            <<<HTML
            <hr role="generic">
            HTML,
            TagVoid::tag()
                ->role('generic')
                ->render(),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithRoleUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <hr role="button">
            HTML,
            TagVoid::tag()
                ->role(Role::BUTTON)
                ->render(),
            "Failed asserting that element renders correctly with 'role' attribute using enum.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::assertSame(
            <<<HTML
            <hr style='test-value'>
            HTML,
            TagVoid::tag()
                ->style('test-value')
                ->render(),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithThemeProvider(): void
    {
        self::assertSame(
            <<<HTML
            <hr class="text-muted">
            HTML,
            TagVoid::tag()
                ->addThemeProvider('muted', DefaultThemeProvider::class)
                ->render(),
            'Failed asserting that theme provider is applied correctly.',
        );
    }

    public function testRenderWithTitle(): void
    {
        self::assertSame(
            <<<HTML
            <hr title="test-value">
            HTML,
            TagVoid::tag()
                ->title('test-value')
                ->render(),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithToString(): void
    {
        self::assertSame(
            <<<HTML
            <hr>
            HTML,
            (string) TagVoid::tag(),
            "Failed asserting that '__toString()' method renders correctly.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::assertSame(
            <<<HTML
            <hr translate="no">
            HTML,
            TagVoid::tag()
                ->translate(false)
                ->render(),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithTranslateUsingEnum(): void
    {
        self::assertSame(
            <<<HTML
            <hr translate="no">
            HTML,
            TagVoid::tag()
                ->translate(Translate::NO)
                ->render(),
            "Failed asserting that element renders correctly with 'translate' attribute using enum.",
        );
    }

    public function testRenderWithUserOverridesGlobalDefaults(): void
    {
        SimpleFactory::setDefaults(
            TagVoid::class,
            [
                'class' => 'from-global',
                'id' => 'id-global',
            ],
        );

        self::assertSame(
            <<<HTML
            <hr class="from-global" id="id-user">
            HTML,
            TagVoid::tag(['id' => 'id-user'])->render(),
            'Failed asserting that user-defined attributes override global defaults correctly.',
        );

        SimpleFactory::setDefaults(
            TagVoid::class,
            [],
        );
    }

    public function testReturnEmptyArrayWhenApplyThemeAndUndefinedTheme(): void
    {
        $tag = TagVoid::tag();

        self::assertEmpty(
            $tag->apply($tag, ''),
            'Failed asserting that applying an undefined theme returns an empty array.',
        );
    }

    public function testReturnEmptyArrayWhenGetDefaultsAndNoDefaultsSet(): void
    {
        $tag = TagVoid::tag();

        self::assertEmpty(
            $tag->getDefaults($tag),
            'Failed asserting that getting defaults returns an empty array when no defaults are set.',
        );
    }
}
