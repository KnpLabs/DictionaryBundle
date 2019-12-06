<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle;

use Knp\DictionaryBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KnpDictionaryBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new Compiler\DictionaryBuildingPass());
        $container->addCompilerPass(new Compiler\DictionaryFactoryBuildingPass());
        $container->addCompilerPass(new Compiler\DictionaryRegistrationPass());
        $container->addCompilerPass(new Compiler\DictionaryTracePass());
    }
}
