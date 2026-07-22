<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Config;

use LogicException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use stdClass;
use UIAwesome\Html\Core\Config\{Call, ComponentContext, Config, Cookbook, Recipe};
use UIAwesome\Html\Core\Exception\Message;
use UIAwesome\Html\Core\Tests\Support\Stub\{ComponentFactory, ConfigApplier, ConfigurableComponent, Theme};

/**
 * Unit tests for the {@see Config} class.
 */
#[Group('config')]
final class ConfigTest extends TestCase
{
    public function testAppliesRecipesInStrictModeByDefault(): void
    {
        $applier = new ConfigApplier();
        $config = new Config(
            new Theme('base', new Recipe('base.field', new Cookbook())),
            $applier,
        );

        $config->apply(new stdClass(), new ComponentContext('field'));

        self::assertSame(
            [true],
            $applier->strictModes,
            "Failed asserting that strict mode defaults to 'true'.",
        );
    }

    public function testAppliesResolvedRecipesInOrder(): void
    {
        $context = new ComponentContext('field.control.email');
        $applier = new ConfigApplier();
        $config = new Config(
            new Theme(
                'flowbite',
                new Recipe('base.control', new Cookbook(new Call('class', 'base'))),
                new Recipe('flowbite.control', new Cookbook(new Call('class', 'flowbite'))),
            ),
            $applier,
            strict: false,
        );
        $component = new stdClass();

        self::assertSame(
            $component,
            $config->apply($component, $context),
            'Failed asserting that the configured component instance is returned.',
        );
        self::assertSame(
            ['base.control', 'flowbite.control'],
            $applier->recipes,
            'Failed asserting that recipes are applied in declaration order.',
        );
        self::assertSame(
            [$context, $context],
            $applier->contexts,
            'Failed asserting that the same context is passed to every recipe application.',
        );
        self::assertSame(
            [false, false],
            $applier->strictModes,
            'Failed asserting that the configured strict mode is forwarded to the applier.',
        );
        self::assertSame(
            'flowbite',
            $config->theme->getName(),
            'Failed asserting that the configured theme is exposed.',
        );
    }

    public function testCreatesComponentWithConfiguredFactory(): void
    {
        $context = new ComponentContext('field.control.email');
        $factory = new ComponentFactory();
        $applier = new ConfigApplier();
        $config = new Config(
            new Theme('base', new Recipe('base.control', new Cookbook())),
            $applier,
            $factory,
        );

        $component = $config->create($context);

        self::assertSame(
            $context,
            $factory->context,
            'Failed asserting that the context is forwarded to the factory.',
        );
        self::assertSame(
            $factory->component,
            $component,
            'Failed asserting that the configured factory-created instance is returned.',
        );
        self::assertSame(
            ['base.control'],
            $applier->recipes,
            'Failed asserting that resolved recipes are applied to the factory-created component.',
        );
    }

    public function testThrowLogicExceptionWhenCreatingWithoutFactory(): void
    {
        $config = new Config(new Theme('base'), new ConfigApplier());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_DOES_NOT_DEFINE_COMPONENT_FACTORY->getMessage(),
        );

        $config->create(new ComponentContext('field.control.email'));
    }

    public function testUsesMethodCallConfigApplierByDefault(): void
    {
        $config = new Config(
            new Theme(
                'base',
                new Recipe('base.field', new Cookbook(new Call('append', 'configured'))),
            ),
        );

        $component = $config->apply(new ConfigurableComponent(), new ComponentContext('field'));

        self::assertInstanceOf(
            ConfigurableComponent::class,
            $component,
            'Failed asserting that the default applier preserves the component type.',
        );
        self::assertSame(
            ['configured'],
            $component->values,
            'Failed asserting that the default applier executes resolved recipe calls.',
        );
    }
}
