<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;
use Knp\DictionaryBundle\Dictionary\Traceable;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class DictionaryTracePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $containerBuilder): void
    {
        if (!$containerBuilder->has(DictionaryDataCollector::class)) {
            return;
        }

        foreach (array_keys($containerBuilder->findTaggedServiceIds(DictionaryRegistrationPass::TAG_DICTIONARY)) as $id) {
            $serviceId  = \sprintf('%s.%s.traceable', $id, md5($id));
            $dictionary = new Reference(\sprintf('%s.inner', $serviceId));
            $traceable  = new Definition(Traceable::class, [$dictionary, new Reference(DictionaryDataCollector::class)]);

            $traceable->setDecoratedService($id);

            $containerBuilder->setDefinition($serviceId, $traceable);
        }
    }
}
