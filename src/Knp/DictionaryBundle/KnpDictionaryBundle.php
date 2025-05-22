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
    public function build(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addCompilerPass(new DictionaryBuildingPass());
        $containerBuilder->addCompilerPass(new DictionaryFactoryBuildingPass());
        $containerBuilder->addCompilerPass(new DictionaryRegistrationPass());
        $containerBuilder->addCompilerPass(new DictionaryTracePass());
    }
}
