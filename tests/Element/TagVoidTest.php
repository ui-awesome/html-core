<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Element;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Tests\Support\Stub\{DefaultProvider, TagVoid};
use UIAwesome\Html\Core\Tests\Support\TestSupport;
use UIAwesome\Html\Core\Values\Direction;

/**
 * Test suite for {@see TagVoid} element functionality and behavior.
 *
 * Validates the management and rendering of the HTML void element according to the HTML Living Standard
 * specification.
 *
 * Ensures correct handling, immutability, and validation of the void tag rendering, supporting all global HTML
 * attributes and provider-based configuration.
 *
 * Test coverage.
 * - Accurate rendering of attributes for the void element.
 * - Application of default providers.
 * - Immutability of the API when setting or overriding attributes.
 * - Proper assignment and overriding of attribute values, including `accesskey`, `class`, `data-*`, `dir`, `id`,
 *   `lang`, `role`, `style`, `title`, and `translate`.
 *
 * {@see DefaultProvider} for default provider implementation.
 * {@see TagVoid} for element implementation details.
 * {@see TestSupport} for assertion utilities.
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Group('element')]
final class TagVoidTest extends TestCase
{
    use TestSupport;

    public function testRenderWithAccesskey(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr accesskey="k">
            HTML,
            TagVoid::tag()->accesskey('k')->render(),
            "Failed asserting that element renders correctly with 'accesskey' attribute.",
        );
    }

    public function testRenderWithAttributes(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr class="test-class">
            HTML,
            TagVoid::tag()->attributes(['class' => 'test-class'])->render(),
            "Failed asserting that element renders correctly with 'attributes()' method.",
        );
    }

    public function testRenderWithClass(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr class="test-class">
            HTML,
            TagVoid::tag()->class('test-class')->render(),
            "Failed asserting that element renders correctly with 'class' attribute.",
        );
    }

    public function testRenderWithDataAttributes(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr data-value="test-value">
            HTML,
            TagVoid::tag()->dataAttributes(['value' => 'test-value'])->render(),
            "Failed asserting that element renders correctly with 'dataAttributes()' method.",
        );
    }

    public function testRenderWithDefaultConfigurationValues(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr class="default-class" title="default-title">
            HTML,
            TagVoid::tag(['class' => 'default-class', 'title' => 'default-title'])->render(),
            'Failed asserting that default configuration values are applied correctly.',
        );
    }

    public function testRenderWithDefaultProvider(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr class="default-provider">
            HTML,
            TagVoid::tag()->addDefaultProvider(DefaultProvider::class)->render(),
            'Failed asserting that default provider is applied correctly.',
        );
    }

    public function testRenderWithDefaultValues(): void
    {
        $instance = TagVoid::tag();

        self::equalsWithoutLE(
            <<<HTML
            <hr>
            HTML,
            $instance->render(),
            'Failed asserting that element renders correctly with default values.',
        );
    }

    public function testRenderWithDir(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr dir="rtl">
            HTML,
            TagVoid::tag()->dir(Direction::RTL)->render(),
            "Failed asserting that element renders correctly with 'dir' attribute.",
        );
    }

    public function testRenderWithHidden(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr hidden>
            HTML,
            TagVoid::tag()->hidden(true)->render(),
            "Failed asserting that element renders correctly with 'hidden' attribute.",
        );
    }

    public function testRenderWithId(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr id="test-id">
            HTML,
            TagVoid::tag()->id('test-id')->render(),
            "Failed asserting that element renders correctly with 'id' attribute.",
        );
    }

    public function testRenderWithLang(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr lang="es">
            HTML,
            TagVoid::tag()->lang('es')->render(),
            "Failed asserting that element renders correctly with 'lang' attribute.",
        );
    }

    public function testRenderWithRole(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr role="generic">
            HTML,
            TagVoid::tag()->role('generic')->render(),
            "Failed asserting that element renders correctly with 'role' attribute.",
        );
    }

    public function testRenderWithStyle(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr style="test-value">
            HTML,
            TagVoid::tag()->style('test-value')->render(),
            "Failed asserting that element renders correctly with 'style' attribute.",
        );
    }

    public function testRenderWithTitle(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr title="test-value">
            HTML,
            TagVoid::tag()->title('test-value')->render(),
            "Failed asserting that element renders correctly with 'title' attribute.",
        );
    }

    public function testRenderWithTranslate(): void
    {
        self::equalsWithoutLE(
            <<<HTML
            <hr translate="no">
            HTML,
            TagVoid::tag()->translate(false)->render(),
            "Failed asserting that element renders correctly with 'translate' attribute.",
        );
    }
}
