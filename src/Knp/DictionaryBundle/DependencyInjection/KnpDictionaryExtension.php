<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryFactoryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\Dictionary;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class KnpDictionaryExtension extends Extension
{
    /**
     * @param array<mixed, mixed> $config
     */
    public function load(array $config, ContainerBuilder $containerBuilder): void
    {
        $configuration = new Configuration();

        $containerBuilder
            ->setParameter(
                'knp_dictionary.configuration',
                $this->processConfiguration($configuration, $config)
            )
        ;

        $containerBuilder
            ->registerForAutoconfiguration(Dictionary::class)
            ->addTag(DictionaryRegistrationPass::TAG_DICTIONARY)
        ;

        $containerBuilder
            ->registerForAutoconfiguration(Dictionary\Factory::class)
            ->addTag(DictionaryFactoryBuildingPass::TAG_FACTORY)
        ;

        $yamlFileLoader = new YamlFileLoader(
            $containerBuilder,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $yamlFileLoader->load('services.yaml');
    }
}
