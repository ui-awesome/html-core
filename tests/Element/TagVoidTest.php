<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use PHPForge\Support\LineEndingNormalizer;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Attribute\Values\{Aria, Data, Direction};
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, TagVoid};

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
 * {@see TestSupport} for assertion utilities.
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
            "Failed asserting that element renders correctly with 'ariaAttribute()' method.",
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

    public function testRenderWithTranslate(): void
    {
        self::assertEquals(
            <<<HTML
            <hr translate="no">
            HTML,
            LineEndingNormalizer::normalize(
                TagVoid::tag()->translate('no')->render(),
            ),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }
}
