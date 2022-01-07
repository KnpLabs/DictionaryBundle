<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\Dictionary\Collection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class DictionaryRegistrationPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryRegistrationPass::class);
    }

    function it_registers_dictionaries(ContainerBuilder $container, Definition $dictionaries)
    {
        $tags = ['foo' => [], 'bar' => [], 'baz' => []];

        $container->getDefinition(Collection::class)->willReturn($dictionaries);
        $container->findTaggedServiceIds(DictionaryRegistrationPass::TAG_DICTIONARY)->willReturn($tags);

        $dictionaries->addMethodCall('add', Argument::that(fn (array $arguments): bool => 'foo' === $arguments[0]->__toString()))->shouldBeCalled();

        $dictionaries->addMethodCall('add', Argument::that(fn (array $arguments): bool => 'bar' === $arguments[0]->__toString()))->shouldBeCalled();

        $dictionaries->addMethodCall('add', Argument::that(fn (array $arguments): bool => 'baz' === $arguments[0]->__toString()))->shouldBeCalled();

        $this->process($container);
    }
}
