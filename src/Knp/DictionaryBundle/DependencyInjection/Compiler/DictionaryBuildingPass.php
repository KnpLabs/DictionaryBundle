<?php

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class DictionaryBuildingPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $configuration = $container->getParameter('knp_dictionary.configuration');

        foreach ($configuration['dictionaries'] as $name => $config) {
            $container->setDefinition(
                sprintf('knp_dictionary.dictionary.%s', $name),
                $this->createDefinition($name, $config)
            );
        }
    }

    /**
     * @param string $name
     * @param array  $config
     *
     * @return Definition
     */
    private function createDefinition($name, array $config)
    {
        $definition = new Definition();

        $definition
            ->setClass('Knp\DictionaryBundle\Dictionary')
            ->setFactory([
                new Reference('knp_dictionary.dictionary.factory.factory_aggregate'),
                'create',
            ])
            ->addArgument($name)
            ->addArgument($config)
            ->addTag(DictionaryRegistrationPass::TAG_DICTIONARY);

        return $definition;
    }
}
