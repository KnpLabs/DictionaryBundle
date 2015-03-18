<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ValueTransformerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $transformers = $container
            ->findTaggedServiceIds('knp_dictionary.value_transformer')
        ;
        $factory = $container
            ->getDefinition('knp_dictionary.dictionary.dictionary_factory')
        ;

        foreach ($transformers as $id => $attributes) {
            $factory->addMethodCall('addTransformer', array(new Reference($id)));
        }
    }
}
