<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Base;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use stdClass;
use UIAwesome\Html\Core\Base\BaseTag;
use UIAwesome\Html\Core\Config\{Call, ComponentContext, Config, Cookbook, Recipe};
use UIAwesome\Html\Core\Exception\{ConfigException, Message};
use UIAwesome\Html\Core\Html;
use UIAwesome\Html\Core\Tests\Support\Stub\{ConfigApplier as ConfigApplierStub, TagBlock, Theme};
use UIAwesome\Html\Interop\Inline;
use UIAwesome\Html\Mixin\HasAttributes;

/**
 * Unit tests for the {@see BaseTag} class.
 */
#[Group('base')]
final class BaseTagTest extends TestCase
{
    public function testAppliesConfigBeforeLocalOverrides(): void
    {
        $config = new Config(
            new Theme(
                'flowbite',
                new Recipe(
                    'flowbite.field',
                    new Cookbook(new Call('class', 'flowbite-field'), new Call('id', 'theme-id')),
                ),
            ),
        );

        self::assertSame(
            <<<HTML
            <div class="flowbite-field" id="local-id">
            </div>
            HTML,
            TagBlock::tag()
                ->config($config, new ComponentContext('field'))
                ->id('local-id')
                ->render(),
            'Failed asserting that local calls override application-scoped config recipes.',
        );
    }

    public function testBeforeRunReturnFalse(): void
    {
        $tag = new class extends BaseTag {
            use HasAttributes;

            protected function getTag(): Inline
            {
                return Inline::SPAN;
            }

            protected function beforeRun(): bool
            {
                return false;
            }

            protected function run(): string
            {
                return Html::inline($this->getTag(), '', $this->attributes);
            }
        };

        self::assertEmpty(
            $tag->render(),
            "Expected empty output when 'beforeRun()' method returns 'false'.",
        );
    }

    public function testConfigInstancesDoNotShareState(): void
    {
        $flowbite = new Config(
            new Theme(
                'flowbite',
                new Recipe('flowbite.field', new Cookbook(new Call('class', 'flowbite-field'))),
            ),
        );
        $daisyUi = new Config(
            new Theme(
                'daisyui',
                new Recipe('daisyui.field', new Cookbook(new Call('class', 'daisyui-field'))),
            ),
        );
        $context = new ComponentContext('field');

        self::assertSame(
            "<div class=\"flowbite-field\">\n</div>",
            TagBlock::tag()
                ->config($flowbite, $context)
                ->render(),
            'Failed asserting that the first config instance applies only its own recipes.',
        );
        self::assertSame(
            "<div class=\"daisyui-field\">\n</div>",
            TagBlock::tag()
                ->config($daisyUi, $context)
                ->render(),
            'Failed asserting that the second config instance applies only its own recipes.',
        );
        self::assertSame(
            "<div>\n</div>",
            TagBlock::tag()->render(),
            'Failed asserting that config application does not alter unconfigured tag instances.',
        );
    }

    public function testDefinesAfterRunAsProtectedLifecycleHook(): void
    {
        self::assertTrue(
            (new ReflectionMethod(BaseTag::class, 'afterRun'))->isProtected(),
            'Failed asserting that subclasses can override the after-run lifecycle hook.',
        );
    }

    public function testThrowConfigExceptionForIncompatibleCustomApplier(): void
    {
        $applier = new ConfigApplierStub();
        $applier->component = new stdClass();
        $context = new ComponentContext('field');

        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_RETURNED_INCOMPATIBLE_COMPONENT->getMessage(
                'field',
                TagBlock::class,
                'stdClass',
            ),
        );

        TagBlock::tag()->config(
            new Config(
                new Theme('base', new Recipe('base.field', new Cookbook())),
                $applier,
            ),
            $context,
        );
    }
}
