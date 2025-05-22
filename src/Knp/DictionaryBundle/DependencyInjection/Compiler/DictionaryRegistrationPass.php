<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection\Compiler;

use Knp\DictionaryBundle\Dictionary\Collection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class DictionaryRegistrationPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    public const TAG_DICTIONARY = 'knp_dictionary.dictionary';

    public function process(ContainerBuilder $containerBuilder): void
    {
        foreach (array_keys($containerBuilder->findTaggedServiceIds(self::TAG_DICTIONARY)) as $id) {
            $containerBuilder
                ->getDefinition(Collection::class)
                ->addMethodCall('add', [new Reference($id)])
            ;
        }
    }
}
