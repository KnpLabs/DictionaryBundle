<?php

namespace Knp\DictionaryBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\ValueTransformerPass;

class KnpDictionaryBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ValueTransformerPass());
        $container->addCompilerPass(new DictionaryBuildingPass());
    }
}
