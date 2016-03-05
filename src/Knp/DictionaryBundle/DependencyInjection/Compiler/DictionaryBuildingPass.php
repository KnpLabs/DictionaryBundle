<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary\Dictionary;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Reference;

class DictionaryBuildingPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $config       = $container->getParameter('knp_dictionary.configuration');
        $class        = $container->getParameter('knp_dictionary.dictionary.dictionary.class');
        $dictionaries = $config['dictionaries'];
        $registry     = $container
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

    /**
     * @param string $class
     * @param string $class
     * @param array  $dictionary
     *
     * @return Definition
     */
    private function createDefinition($class, $name, array $dictionary)
    {
        $content    = $this->createDictionary($dictionary);
        $definition = new Definition();

        return $definition
            ->setClass($class)
            ->setFactory([
                new Reference('knp_dictionary.dictionary.dictionary_factory'),
                'create'
            ])
            ->addArgument($name)
            ->addArgument($content)
            ->addArgument($dictionary['type'])
        ;
    }

    /**
     * @param array $dictionary
     *
     * @throws \RuntimeException
     *
     * @return array
     */
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
