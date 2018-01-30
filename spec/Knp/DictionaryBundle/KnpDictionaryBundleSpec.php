<?php

namespace spec\Knp\DictionaryBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class KnpDictionaryBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\KnpDictionaryBundle');
    }

    function it_registers_compiler_passes(ContainerBuilder $container)
    {
        $container
            ->addCompilerPass(Argument::type('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryFactoryBuildingPass'))
            ->shouldBeCalled();

        $container
            ->addCompilerPass(Argument::type('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass'))
            ->shouldBeCalled();

        $container
            ->addCompilerPass(Argument::type('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass'))
            ->shouldBeCalled();

        $container
            ->addCompilerPass(Argument::type('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryTracePass'))
            ->shouldBeCalled();

        $this->build($container);
    }
}
