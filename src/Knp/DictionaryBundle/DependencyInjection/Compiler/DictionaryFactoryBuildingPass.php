<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary\Factory\Aggregate;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class DictionaryFactoryBuildingPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    public const TAG_FACTORY = 'knp_dictionary.factory';

    public function process(ContainerBuilder $containerBuilder): void
    {
        foreach (array_keys($containerBuilder->findTaggedServiceIds(self::TAG_FACTORY)) as $id) {
            $containerBuilder
                ->findDefinition(Aggregate::class)
                ->addMethodCall('addFactory', [new Reference($id)])
            ;
        }
    }
}
