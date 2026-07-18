<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary;
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

        /** @var array<string, list<array{string, string}>> $aliases */
        $aliases = [];

        foreach ($configuration['dictionaries'] as $name => $config) {
            $serviceId = \sprintf('knp_dictionary.dictionary.%s', $name);

            $containerBuilder->setDefinition(
                $serviceId,
                $this->createDefinition($name, $config)
            );

            if (null !== $argumentName = $this->normalizeArgumentName($name)) {
                $aliases[$argumentName][] = [$serviceId, $name.'.dictionary'];
            }
        }

        foreach ($aliases as $argumentName => $candidates) {
            if (1 !== \count($candidates)) {
                continue;
            }

            if ($containerBuilder->hasAlias(Dictionary::class.' $'.$argumentName)) {
                continue;
            }

            $containerBuilder->registerAliasForArgument($candidates[0][0], Dictionary::class, $candidates[0][1]);
        }
    }

    private function normalizeArgumentName(string $name): ?string
    {
        $words = preg_replace('/[^a-zA-Z0-9\x7f-\xff]++/', ' ', $name.'.dictionary');

        if (null === $words) {
            return null;
        }

        $argumentName = lcfirst(str_replace(' ', '', ucwords($words)));

        return 1 === preg_match('/^[a-zA-Z_\x7f-\xff]/', $argumentName) ? $argumentName : null;
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
