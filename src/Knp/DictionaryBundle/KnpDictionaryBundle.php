<?php

namespace Knp\DictionaryBundle;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryFactoryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KnpDictionaryBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DictionaryBuildingPass());
        $container->addCompilerPass(new DictionaryRegistrationPass());
        $container->addCompilerPass(new DictionaryFactoryBuildingPass());
    }
}
