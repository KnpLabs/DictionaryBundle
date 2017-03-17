<?php

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class DictionaryRegistrationPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass');
    }

    function it_registers_dictionaries(ContainerBuilder $container, Definition $registry)
    {
        $tags = ['foo' => [], 'bar' => [], 'baz' => []];

        $container->getDefinition('knp_dictionary.dictionary.dictionary_registry')->willReturn($registry);
        $container->findTaggedServiceIds(DictionaryRegistrationPass::TAG_DICTIONARY)->willReturn($tags);

        $registry->addMethodCall('add', Argument::that(function (array $arguments) {
            return $arguments[0]->__toString() === 'foo';
        }))->shouldBeCalled();

        $registry->addMethodCall('add', Argument::that(function (array $arguments) {
            return $arguments[0]->__toString() === 'bar';
        }))->shouldBeCalled();

        $registry->addMethodCall('add', Argument::that(function (array $arguments) {
            return $arguments[0]->__toString() === 'baz';
        }))->shouldBeCalled();

        $this->process($container);
    }
}
