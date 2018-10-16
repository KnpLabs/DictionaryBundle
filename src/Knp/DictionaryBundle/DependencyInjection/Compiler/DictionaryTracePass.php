<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary\Traceable;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class DictionaryTracePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->has(DictionaryDataCollector::class)) {
            return;
        }

        $collector = new Reference(DictionaryDataCollector::class);
        $services  = $container->findTaggedServiceIds(DictionaryRegistrationPass::TAG_DICTIONARY);

        foreach (array_keys($services) as $id) {
            $serviceId = sprintf('%s.%s.traceable', $id, md5($id));

            $dictionary = new Reference(sprintf('%s.inner', $serviceId));

            $traceable = new Definition(Traceable::class, [$dictionary, $collector]);
            $traceable->setDecoratedService($id);

            $container->setDefinition($serviceId, $traceable);
        }
    }
}
