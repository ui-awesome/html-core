<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Config;

use ArgumentCountError;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use UIAwesome\Html\Core\Config\{Call, ComponentContext, ConfigApplier, Cookbook, Recipe};
use UIAwesome\Html\Core\Exception\{ConfigException, Message};
use UIAwesome\Html\Core\Tests\Support\Stub\{ConfigurableComponent, ExtendedComponent};

/**
 * Unit tests for the {@see ConfigApplier} class.
 */
#[Group('config')]
final class ConfigApplierTest extends TestCase
{
    public function testAcceptsSubclassReturnValueInStrictMode(): void
    {
        $configApplier = new ConfigApplier();

        $configured = $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe(
                'base.field',
                new Cookbook(new Call('upgrade'), new Call('append', 'configured')),
            ),
            new ComponentContext('field'),
        );

        self::assertInstanceOf(
            ExtendedComponent::class,
            $configured,
            'Failed asserting that a subclass return value is accepted as compatible.',
        );
        self::assertSame(
            ['configured'],
            $configured->values,
            'Failed asserting that subsequent calls continue on the subclass instance.',
        );
    }

    public function testAppliesDuplicateCallsInDeclarationOrder(): void
    {
        $configApplier = new ConfigApplier();
        $component = new ConfigurableComponent();

        $configured = $configApplier->apply(
            $component,
            new Recipe(
                'flowbite.field',
                new Cookbook(new Call('append', 'base'), new Call('append', 'flowbite')),
            ),
            new ComponentContext('field.control.email'),
        );

        self::assertNotSame(
            $component,
            $configured,
            'Failed asserting that the configured immutable component instance is returned.',
        );
        self::assertInstanceOf(
            ConfigurableComponent::class,
            $configured,
            'Failed asserting that config application preserves the component type.',
        );
        self::assertSame(
            ['base', 'flowbite'],
            $configured->values,
            'Failed asserting that duplicate calls are applied in declaration order.',
        );
        self::assertSame(
            [],
            $component->values,
            'Failed asserting that applying a recipe does not mutate the original component.',
        );
    }

    public function testForwardsMultiplePositionalArgumentsInOrder(): void
    {
        $configApplier = new ConfigApplier();

        $configured = $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe(
                'base.field',
                new Cookbook(new Call('appendPair', 'btn', 'primary', ':')),
            ),
            new ComponentContext('field'),
        );

        self::assertInstanceOf(
            ConfigurableComponent::class,
            $configured,
            'Failed asserting that multi-argument invocation preserves the component type.',
        );
        self::assertSame(
            ['btn:primary'],
            $configured->values,
            'Failed asserting that all positional arguments reach the method in order.',
        );
    }

    public function testReturnsSameComponentForEmptyCookbook(): void
    {
        $component = new ConfigurableComponent();

        self::assertSame(
            $component,
            (new ConfigApplier())->apply(
                $component,
                new Recipe('base.field', new Cookbook()),
                new ComponentContext('field'),
            ),
            'Failed asserting that an empty cookbook returns the original component.',
        );
    }

    public function testSkipsIncompatibleReturnValueInNonStrictMode(): void
    {
        $configApplier = new ConfigApplier();

        $configured = $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe(
                'base.field',
                new Cookbook(new Call('returnScalar'), new Call('append', 'configured')),
            ),
            new ComponentContext('field'),
            false,
        );

        self::assertInstanceOf(
            ConfigurableComponent::class,
            $configured,
            'Failed asserting that non-strict return handling preserves the component type.',
        );
        self::assertSame(
            ['configured'],
            $configured->values,
            'Failed asserting that a non-strict recipe continues after an incompatible return value.',
        );
    }

    public function testSkipsUnavailableMethodInNonStrictMode(): void
    {
        $configApplier = new ConfigApplier();

        $configured = $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe(
                'base.field',
                new Cookbook(new Call('unknown'), new Call('append', 'configured')),
            ),
            new ComponentContext('field'),
            false,
        );

        self::assertInstanceOf(
            ConfigurableComponent::class,
            $configured,
            'Failed asserting that non-strict method handling preserves the component type.',
        );
        self::assertSame(
            ['configured'],
            $configured->values,
            'Failed asserting that a non-strict recipe continues after an unavailable method.',
        );
    }

    public function testThrowConfigExceptionForCallExecutionFailure(): void
    {
        $applier = new ConfigApplier();
        $component = new ConfigurableComponent();
        $recipe = new Recipe('base.field', new Cookbook(new Call('append')));
        $context = new ComponentContext('field');

        try {
            $applier->apply($component, $recipe, $context);

            self::fail(
                'Failed asserting that an invalid method invocation throws a config exception.',
            );
        } catch (ConfigException $exception) {
            self::assertSame(
                Message::CONFIG_CALL_EXECUTION_FAILED->getMessage(
                    'append',
                    'base.field',
                    'field',
                    ConfigurableComponent::class,
                    'Too few arguments to function '
                    . ConfigurableComponent::class
                    . '::append(), 0 passed and exactly 1 expected',
                ),
                $exception->getMessage(),
                'Failed asserting that an execution failure identifies its recipe and component.',
            );
            self::assertInstanceOf(
                ArgumentCountError::class,
                $exception->getPrevious(),
                'Failed asserting that an execution failure preserves the original exception.',
            );
        }
    }

    public function testThrowConfigExceptionForComponentFailure(): void
    {
        $configApplier = new ConfigApplier();

        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_CALL_EXECUTION_FAILED->getMessage(
                'fail',
                'base.field',
                'field',
                ConfigurableComponent::class,
                'Component call failed.',
            ),
        );
        $this->expectExceptionCode(0);

        $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe('base.field', new Cookbook(new Call('fail'))),
            new ComponentContext('field'),
        );
    }

    public function testThrowConfigExceptionForDifferentComponentReturnValue(): void
    {
        $configApplier = new ConfigApplier();

        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_CALL_RETURNED_INCOMPATIBLE_VALUE->getMessage(
                'returnOtherComponent',
                'base.field',
                'field',
                ConfigurableComponent::class,
                'stdClass',
            ),
        );

        $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe('base.field', new Cookbook(new Call('returnOtherComponent'))),
            new ComponentContext('field'),
        );
    }

    public function testThrowConfigExceptionForNonPublicMethod(): void
    {
        $configApplier = new ConfigApplier();

        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_CALL_METHOD_NOT_AVAILABLE->getMessage(
                'nonPublicCall',
                'base.field',
                'field',
                ConfigurableComponent::class,
            ),
        );

        $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe('base.field', new Cookbook(new Call('nonPublicCall'))),
            new ComponentContext('field'),
        );
    }

    public function testThrowConfigExceptionForScalarReturnValue(): void
    {
        $configApplier = new ConfigApplier();

        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_CALL_RETURNED_INCOMPATIBLE_VALUE->getMessage(
                'returnScalar',
                'base.field',
                'field',
                ConfigurableComponent::class,
                'string',
            ),
        );

        $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe('base.field', new Cookbook(new Call('returnScalar'))),
            new ComponentContext('field'),
        );
    }

    public function testThrowConfigExceptionForStaticMethod(): void
    {
        $configApplier = new ConfigApplier();

        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_CALL_METHOD_NOT_AVAILABLE->getMessage(
                'staticCall',
                'base.field',
                'field',
                ConfigurableComponent::class,
            ),
        );

        $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe('base.field', new Cookbook(new Call('staticCall'))),
            new ComponentContext('field'),
        );
    }

    public function testThrowConfigExceptionForUnknownMethod(): void
    {
        $configApplier = new ConfigApplier();

        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage(
            Message::CONFIG_CALL_METHOD_NOT_AVAILABLE->getMessage(
                'unknown',
                'base.field',
                'field.control.email',
                ConfigurableComponent::class,
            ),
        );

        $configApplier->apply(
            new ConfigurableComponent(),
            new Recipe('base.field', new Cookbook(new Call('unknown'))),
            new ComponentContext('field.control.email'),
        );
    }
}
