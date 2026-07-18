<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary;
use Knp\DictionaryBundle\Dictionary\Collection;
use Knp\DictionaryBundle\Dictionary\Factory\Aggregate;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class DictionaryBuildingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $containerBuilder): void
    {
        $configuration = $containerBuilder->getParameter('knp_dictionary.configuration');

        if (false === \is_array($configuration)) {
            throw new \Exception('The configuration "knp_dictionary.dictionaries" should be an array.');
        }

        /** @var array<string, list<string>> $aliases */
        $aliases = [];

        foreach ($configuration['dictionaries'] as $name => $config) {
            $serviceId = \sprintf('knp_dictionary.dictionary.%s', $name);

            $containerBuilder->setDefinition(
                $serviceId,
                $this->createDefinition($name, $config)
            );

            if (null !== $argumentName = $this->normalizeArgumentName($name)) {
                $aliases[$argumentName][] = $name;
            }
        }

        foreach ($aliases as $argumentName => $candidates) {
            if (1 !== \count($candidates)) {
                continue;
            }

            if ($containerBuilder->hasAlias(Dictionary::class.' $'.$argumentName)) {
                continue;
            }

            $name      = $candidates[0];
            $serviceId = \sprintf('knp_dictionary.dictionary_autowiring.%s', $name);
            $containerBuilder->setDefinition(
                $serviceId,
                $this->createCollectionReferenceDefinition($name)
            );
            $containerBuilder->registerAliasForArgument($serviceId, Dictionary::class, $name.'.dictionary');
        }
    }

    private function normalizeArgumentName(string $name): ?string
    {
        $words = preg_replace('/[^a-zA-Z0-9\x7f-\xff]++/', ' ', $name.'.dictionary') ?? '';

        $argumentName = lcfirst(str_replace(' ', '', ucwords($words)));

        return 1 === preg_match('/^[a-zA-Z_\x7f-\xff]/', $argumentName) ? $argumentName : null;
    }

    private function createCollectionReferenceDefinition(string $name): Definition
    {
        return (new Definition(Dictionary::class))
            ->setFactory([new Reference(Collection::class), 'offsetGet'])
            ->addArgument($name)
        ;
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
