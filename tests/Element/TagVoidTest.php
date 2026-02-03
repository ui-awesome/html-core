<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use PHPForge\Support\LineEndingNormalizer;
use PHPForge\Support\ReflectionHelper;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Attribute\Values\{Aria, Data, Direction, Event, Language, Role, Translate};
use UIAwesome\Html\Core\Factory\SimpleFactory;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, DefaultThemeProvider, TagVoid};

/**
 * Unit tests for {@see TagVoid} element rendering and attribute handling.
 *
 * Verifies rendered output and provider application behavior for {@see TagVoid}.
 *
 * Test coverage.
 * - Applies default providers.
 * - Renders void elements with representative global HTML attributes.
 *
 * {@see TagVoid} for element implementation details.
 * {@see DefaultProvider} for default provider implementation.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('element')]
final class TagVoidTest extends TestCase
{
    public function testRenderWithAccesskey(): void
    {
        self::assertEquals(
            <<<HTML
            <hr accesskey="k">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->accesskey('k')->render(),
            ),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAddAriaAttribute(): void
    {
        self::assertEquals(
            <<<HTML
            <hr aria-pressed="true">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->addAriaAttribute('pressed', true)->render(),
            ),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method.",
        );
    }

    public function testRenderWithAddAriaAttributeUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <hr aria-pressed="true">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->addAriaAttribute(Aria::PRESSED, true)->render(),
            ),
            "Failed asserting that element renders correctly with 'addAriaAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddDataAttribute(): void
    {
        self::assertEquals(
            <<<HTML
            <hr data-value="value">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->addDataAttribute('value', 'value')->render(),
            ),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method.",
        );
    }

    public function testRenderWithAddDataAttributeUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <hr data-value="value">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->addDataAttribute(Data::VALUE, 'value')->render(),
            ),
            "Failed asserting that element renders correctly with 'addDataAttribute()' method using enum.",
        );
    }

    public function testRenderWithAddEvent(): void
    {
        self::assertEquals(
            <<<HTML
            <hr onclick="handleClick()">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->addEvent(Event::CLICK, 'handleClick()')->render(),
            ),
            "Failed asserting that element renders correctly with 'addEvent()' method.",
        );
    }

    public function testRenderWithAriaAttributes(): void
    {
        self::assertEquals(
            <<<HTML
            <hr aria-label="Close" aria-hidden="false" aria-controls="modal-1">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->ariaAttributes(
                    [
                        'label' => 'Close',
                        'hidden' => false,
                        'controls' => static fn(): string => 'modal-1',
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
            <hr class="test-class">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->attributes(['class' => 'test-class'])->render(),
            ),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::assertEquals(
            <<<HTML
            <hr class="test-class">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->class('test-class')->render(),
            ),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::assertEquals(
            <<<HTML
            <hr data-value="test-value">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->dataAttributes(['value' => 'test-value'])->render(),
            ),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationValues(): void
    {
        self::assertEquals(
            <<<HTML
            <hr class="default-class" title="default-title">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag(['class' => 'default-class', 'title' => 'default-title'])->render(),
            ),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::assertEquals(
            <<<HTML
            <hr class="default-provider">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->addDefaultProvider(DefaultProvider::class)->render(),
            ),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        $instance = TagVoid::tag();

        self::assertEquals(
            <<<HTML
            <hr>
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
            <hr dir="rtl">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->dir('rtl')->render(),
            ),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithDirUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <hr dir="ltr">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->dir(Direction::LTR)->render(),
            ),
            "Failed asserting that element renders correctly with 'dir' attribute using enum.",
        );
    }

    public function testRenderWithEvents(): void
    {
        self::assertEquals(
            <<<HTML
            <hr onchange="handleChange()">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->events(['change' => 'handleChange()'])->render(),
            ),
            "Failed asserting that element renders correctly with 'events()' method.",
        );
    }

    public function testRenderWithGlobalDefaultsAreApplied(): void
    {
        $previous = SimpleFactory::getDefaults(TagVoid::class);

        try {
            SimpleFactory::setDefaults(TagVoid::class, ['class' => 'from-global']);

            self::assertEquals(
                <<<HTML
                <hr class="from-global">
                HTML,
                LineEndingNormalizer::normalize(
                    TagVoid::tag()->render(),
                ),
                'Failed asserting that global defaults are applied correctly.',
            );
        } finally {
            SimpleFactory::setDefaults(TagVoid::class, $previous);
        }
    }

    public function testRenderWithHidden(): void
    {
        self::assertEquals(
            <<<HTML
            <hr hidden>
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->hidden(true)->render(),
            ),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::assertEquals(
            <<<HTML
            <hr id="test-id">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->id('test-id')->render(),
            ),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::assertEquals(
            <<<HTML
            <hr lang="es">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->lang('es')->render(),
            ),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithLangUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <hr lang="es">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->lang(Language::SPANISH)->render(),
            ),
            "Failed asserting that element renders correctly with 'lang' attribute using enum.",
        );
    }

    public function testRenderWithLoadDefault(): void
    {
        $tag = TagVoid::tag();

        self::assertEmpty(
            ReflectionHelper::invokeMethod($tag, 'loadDefault'),
            'Failed asserting that loading default definitions returns an empty array when no defaults are set.',
        );
    }

    public function testRenderWithRole(): void
    {
        self::assertEquals(
            <<<HTML
            <hr role="generic">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->role('generic')->render(),
            ),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithRoleUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <hr role="button">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->role(Role::BUTTON)->render(),
            ),
            "Failed asserting that element renders correctly with 'role' attribute using enum.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::assertEquals(
            <<<HTML
            <hr style='test-value'>
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->style('test-value')->render(),
            ),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithThemeProvider(): void
    {
        self::assertEquals(
            <<<HTML
            <hr class="text-muted">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->addThemeProvider('muted', DefaultThemeProvider::class)->render(),
            ),
            'Failed asserting that theme provider is applied correctly.',
        );
    }

    public function testRenderWithTitle(): void
    {
        self::assertEquals(
            <<<HTML
            <hr title="test-value">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->title('test-value')->render(),
            ),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithToString(): void
    {
        self::assertEquals(
            <<<HTML
            <hr>
            HTML,
            LineEndingNormalizer::normalize(
                (string) TagVoid::tag(),
            ),
            "Failed asserting that '__toString()' method renders correctly.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::assertEquals(
            <<<HTML
            <hr translate="no">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->translate(false)->render(),
            ),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }

    public function testRenderWithTranslateUsingEnum(): void
    {
        self::assertEquals(
            <<<HTML
            <hr translate="no">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->translate(Translate::NO)->render(),
            ),
            "Failed asserting that element renders correctly with 'translate' attribute using enum.",
        );
    }

    public function testRenderWithUserOverridesGlobalDefaults(): void
    {
        $previous = SimpleFactory::getDefaults(TagVoid::class);

        try {
            SimpleFactory::setDefaults(TagVoid::class, ['class' => 'from-global', 'id' => 'id-global']);

            self::assertEquals(
                <<<HTML
                <hr class="from-global" id="id-user">
                HTML,
                LineEndingNormalizer::normalize(
                    TagVoid::tag(['id' => 'id-user'])->render(),
                ),
                'Failed asserting that user-defined attributes override global defaults correctly.',
            );
        } finally {
            SimpleFactory::setDefaults(TagVoid::class, $previous);
        }
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
