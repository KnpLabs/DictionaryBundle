<?php

namespace Knp\DictionaryBundle;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryFactoryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryTracePass;
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
        $container->addCompilerPass(new DictionaryFactoryBuildingPass());
        $container->addCompilerPass(new DictionaryRegistrationPass());
        $container->addCompilerPass(new DictionaryTracePass());
    }
}
