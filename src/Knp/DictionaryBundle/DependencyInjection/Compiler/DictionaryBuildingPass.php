<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary;
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
        $config = $container->getParameter('knp_dictionary.configuration');

        foreach ($config['dictionaries'] as $name => $dictionary) {
            $container->setDefinition(
                sprintf('knp_dictionary.dictionary.%s', $name),
                $this->createDefinition($name, $dictionary)
            );
        }
    }

    /**
     * @param string $name
     * @param array  $dictionary
     *
     * @return Definition
     */
    private function createDefinition($name, array $dictionary)
    {
        $content    = $this->createDictionary($dictionary);
        $definition = new Definition();

        return $definition
            ->setClass('Knp\DictionaryBundle\Dictionary')
            ->setFactory([
                new Reference('knp_dictionary.dictionary.dictionary_factory'),
                'createFromArray',
            ])
            ->addArgument($name)
            ->addArgument($content)
            ->addArgument($dictionary['type'])
            ->addTag(DictionaryRegistrationPass::TAG_DICTIONARY)
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
