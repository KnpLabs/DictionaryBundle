<?php

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\ValueTransformerPass;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ValueTransformerPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DependencyInjection\Compiler\ValueTransformerPass');
    }

    function it_registers_transformers(ContainerBuilder $container, Definition $factory)
    {
        $tags = ['foo' => [], 'bar' => [], 'baz' => []];

        $container->getDefinition('knp_dictionary.dictionary.dictionary_factory')->willReturn($factory);
        $container->findTaggedServiceIds(ValueTransformerPass::TAG_TRANSFORMER)->willReturn($tags);

        $factory->addMethodCall('addTransformer', Argument::that(function (array $arguments) {
            return $arguments[0]->__toString() === 'foo';
        }))->shouldBeCalled();

        $factory->addMethodCall('addTransformer', Argument::that(function (array $arguments) {
            return $arguments[0]->__toString() === 'bar';
        }))->shouldBeCalled();

        $factory->addMethodCall('addTransformer', Argument::that(function (array $arguments) {
            return $arguments[0]->__toString() === 'baz';
        }))->shouldBeCalled();

        $this->process($container);
    }
}
