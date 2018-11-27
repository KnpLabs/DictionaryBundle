<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary\Factory\Aggregate;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DictionaryFactoryBuildingPass implements CompilerPassInterface
{
    const TAG_FACTORY = 'knp_dictionary.factory';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds(self::TAG_FACTORY) as $id => $tags) {
            $container
                ->findDefinition(Aggregate::class)
                ->addMethodCall('addFactory', [new Reference($id)])
            ;
        }
    }
}
