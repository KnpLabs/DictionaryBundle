<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Exception;
use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Factory\Aggregate;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class DictionaryBuildingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $configuration = $container->getParameter('knp_dictionary.configuration');

        if (!\is_array($configuration)) {
            throw new Exception('The configuration "knp_dictionary.dictionaries" should be an array.');
        }

        foreach ($configuration['dictionaries'] as $name => $config) {
            $container->setDefinition(
                sprintf('knp_dictionary.dictionary.%s', $name),
                $this->createDefinition($name, $config)
            );
        }
    }

    /**
     * @param mixed[] $config
     */
    private function createDefinition(string $name, array $config): Definition
    {
        $definition = new Definition();

        $definition
            ->setClass(Dictionary::class)
            ->setFactory([
                new Reference(Aggregate::class),
                'create',
            ])
            ->addArgument($name)
            ->addArgument($config)
            ->addTag(DictionaryRegistrationPass::TAG_DICTIONARY)
        ;

        return $definition;
    }
}
