<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\Dictionary\Collection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class DictionaryRegistrationPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DictionaryRegistrationPass::class);
    }

    function it_registers_dictionaries(ContainerBuilder $container, Definition $dictionaries, Definition $definition)
    {
        $tags = ['foo' => [], 'bar' => [], 'baz' => []];

        $container->getDefinition(Collection::class)->willReturn($dictionaries);
        $container->findTaggedServiceIds(DictionaryRegistrationPass::TAG_DICTIONARY)->willReturn($tags);

        foreach (['foo', 'bar', 'baz'] as $id) {
            $dictionaries
                ->addMethodCall('add', Argument::exact([new Reference($id)]))
                ->shouldBeCalledTimes(1)
                ->willReturn($definition)
            ;
        }

        $this->process($container);
    }
}
