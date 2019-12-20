<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle;

use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryFactoryBuildingPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegistrationPass;
use Knp\DictionaryBundle\DependencyInjection\Compiler\DictionaryTracePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class KnpDictionaryBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new DictionaryBuildingPass());
        $container->addCompilerPass(new DictionaryFactoryBuildingPass());
        $container->addCompilerPass(new DictionaryRegistrationPass());
        $container->addCompilerPass(new DictionaryTracePass());
    }
}
