<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class DictionaryBuildingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('knp_dictionary.configuration');
        $class  = $container->getParameter('knp_dictionary.dictionary.dictionary.class');
        $dictionaries = $config['dictionaries'];
        $registry = $container
            ->getDefinition('knp_dictionary.dictionary.dictionary_registry')
        ;

        foreach ($dictionaries as $name => $dictionary) {
            $definition = $this->createDefinition($class, $name, $dictionary);
            $registry->addMethodCall('set', array($name, $definition));
            $container->setDefinition(
                sprintf('knp_dictionary.dictionary.%s', $name),
                $definition
            );
        }
    }

    private function createDefinition($class, $name, array $dictionary)
    {
        $definition = new Definition();

        return $definition
            ->setClass($class)
            ->addArgument($name)
            ->addArgument($dictionary)
        ;
    }
}
