<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

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
        if (false === $container->has('knp_dictionary.data_collector.dictionary_data_collector')) {
            return;
        }

        $collector = new Reference('knp_dictionary.data_collector.dictionary_data_collector');
        $services  = $container->findTaggedServiceIds(DictionaryRegistrationPass::TAG_DICTIONARY);

        foreach ($services as $id => $tags) {
            $serviceId = sprintf('%s.%s.traceable', $id, md5($id));

            $dictionary = new Reference(sprintf('%s.inner', $serviceId));

            $traceable = new Definition('Knp\DictionaryBundle\Dictionary\TraceableDictionary', [$dictionary, $collector]);
            $traceable->setDecoratedService($id);

            $container->setDefinition($serviceId, $traceable);
        }
    }
}
