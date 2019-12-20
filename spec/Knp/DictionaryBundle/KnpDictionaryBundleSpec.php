<?php

declare(strict_types=1);

namespace spec\Knp\DictionaryBundle;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryFactoryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryTracePass;
use Knp\DictionaryBundle\KnpDictionaryBundle;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class KnpDictionaryBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(KnpDictionaryBundle::class);
    }

    function it_registers_compiler_passes(ContainerBuilder $container)
    {
        $container
            ->addCompilerPass(Argument::type(DictionaryFactoryBuildingPass::class))
            ->shouldBeCalled()
        ;

        $container
            ->addCompilerPass(Argument::type(DictionaryBuildingPass::class))
            ->shouldBeCalled()
        ;

        $container
            ->addCompilerPass(Argument::type(DictionaryRegistrationPass::class))
            ->shouldBeCalled()
        ;

        $container
            ->addCompilerPass(Argument::type(DictionaryTracePass::class))
            ->shouldBeCalled()
        ;

        $this->build($container);
    }
}
