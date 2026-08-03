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

        $aliases = [];

        foreach ($configuration['dictionaries'] as $name => $config) {
            $containerBuilder->setDefinition(
                \sprintf('knp_dictionary.dictionary.%s', $name),
                $this->createDefinition($name, $config)
            );

            if (null !== $argumentName = $this->normalizeArgumentName($name)) {
                $aliases[$argumentName] = \array_key_exists($argumentName, $aliases) ? null : $name;
            }
        }

        foreach ($aliases as $argumentName => $name) {
            if (null === $name) {
                continue;
            }

            if ($containerBuilder->hasAlias(Dictionary::class.' $'.$argumentName)) {
                continue;
            }

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
        // Match Symfony's #[Target] parser, whose API differs in 5.4.
        $words = preg_replace('/[^a-zA-Z0-9\x7f-\xff]++/', ' ', $name.'.dictionary') ?? '';

        $argumentName = lcfirst(str_replace(' ', '', ucwords($words)));

        return 1 === preg_match('/^[a-zA-Z_\x7f-\xff]/', $argumentName) ? $argumentName : null;
    }

    private function createCollectionReferenceDefinition(string $name): Definition
    {
        return (new Definition(Dictionary::class, [$name]))
            ->setFactory([new Reference(Collection::class), 'offsetGet'])
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
