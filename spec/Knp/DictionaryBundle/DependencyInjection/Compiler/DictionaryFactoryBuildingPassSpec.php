<?php

namespace spec\Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryFactoryBuildingPass;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class DictionaryFactoryBuildingPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryFactoryBuildingPass');
    }

    function it_adds_tagged_services_into_factory_aggregate(
        ContainerBuilder $container,
        Definition $factory1,
        Definition $factory2,
        Definition $factory3,
        Definition $aggregate
    ) {
        $container
            ->findTaggedServiceIds(DictionaryFactoryBuildingPass::TAG_FACTORY)
            ->willReturn([
                'factory1' => $factory1,
                'factory2' => $factory2,
                'factory3' => $factory3,
            ])
        ;

        $container
            ->findDefinition('knp_dictionary.dictionary.factory.factory_aggregate')
            ->willReturn($aggregate)
        ;

        $aggregate->addMethodCall('addFactory', Argument::that(function ($reference) {
            expect($reference)->toHaveType('Reference');
            expect($reference->__toString())->toBe('factory1');
        }));

        $aggregate->addMethodCall('addFactory', Argument::that(function ($reference) {
            expect($reference)->toHaveType('Reference');
            expect($reference->__toString())->toBe('factory2');
        }));

        $aggregate->addMethodCall('addFactory', Argument::that(function ($reference) {
            expect($reference)->toHaveType('Reference');
            expect($reference->__toString())->toBe('factory3');
        }));

        $this->process($container);
    }
}
