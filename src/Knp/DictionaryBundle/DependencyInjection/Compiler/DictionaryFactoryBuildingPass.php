<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DictionaryFactoryBuildingPass implements CompilerPassInterface
{
    const TAG_FACTORY = 'knp_dictionary.factory';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $factories = $container->findTaggedServiceIds(self::TAG_FACTORY);

        $factoryAggregate = $container->findDefinition('knp_dictionary.dictionary.factory.factory_aggregate');

        foreach (array_keys($factories) as $id) {
            $factoryAggregate->addMethodCall('addFactory', [new Reference($id)]);
        }
    }
}
