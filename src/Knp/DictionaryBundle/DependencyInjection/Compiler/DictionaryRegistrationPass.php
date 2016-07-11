<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary\Dictionary;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DictionaryRegistrationPass implements CompilerPassInterface
{
    const TAG_DICTIONARY = 'knp_dictionary.dictionary';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $registry = $container
            ->getDefinition('knp_dictionary.dictionary.dictionary_registry')
        ;

        $services = $container->findTaggedServiceIds(self::TAG_DICTIONARY);

        foreach ($services as $id => $tags) {
            $dictionary = new Reference($id);
            $registry->addMethodCall('add', [$dictionary]);
        }
    }
}
