<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ValueTransformerPass implements CompilerPassInterface
{
    const TAG_TRANSFORMER = 'knp_dictionary.value_transformer';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $transformers = $container->findTaggedServiceIds(self::TAG_TRANSFORMER);
        $factory      = $container->getDefinition('knp_dictionary.dictionary.dictionary_factory');

        foreach ($transformers as $id => $attributes) {
            $factory->addMethodCall('addTransformer', [new Reference($id)]);
        }
    }
}
