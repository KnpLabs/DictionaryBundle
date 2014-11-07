<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Knp\DictionaryBundle\Dictionary\Dictionary;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

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
        $values     = $this->createDictionary($dictionary);
        $definition = new Definition();

        return $definition
            ->setClass($class)
            ->addArgument($name)
            ->addArgument($values)
        ;
    }

    private function createDictionary(array $dictionary)
    {
        $type    = $dictionary['type'];
        $content = $dictionary['content'];

        switch ($type) {
            case Dictionary::VALUE_AS_KEY:
                return array_combine($content, $content);
            case Dictionary::VALUE:
                return array_values($content);
            case Dictionary::KEY_VALUE:
                return $content;
        }

        throw new RuntimeException(sprintf(
            'Unknown dictionary type "%s"',
            $type
        ));
    }
}
