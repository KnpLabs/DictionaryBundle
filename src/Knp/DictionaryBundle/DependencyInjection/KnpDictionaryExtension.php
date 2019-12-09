<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KnpDictionaryExtension extends Extension
{
    /**
     * @param array<mixed, mixed> $config
     */
    public function load(array $config, ContainerBuilder $container): void
    {
        $configuration = new Configuration();

        $container
            ->setParameter(
                'knp_dictionary.configuration',
                $this->processConfiguration($configuration, $config)
            )
        ;

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yaml');
    }
}
