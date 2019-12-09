<?php

declare(strict_types=1);

namespace spec\PHPSpec;

use PhpSpec;

final class Extension implements PhpSpec\Extension
{
    /**
     * @param mixed[] $params
     */
    public function load(PhpSpec\ServiceContainer $container, array $params): void
    {
        $container->define(
            OneOfMatcher::class,
            function (): OneOfMatcher {
                return new OneOfMatcher();
            },
            ['matchers']
        );
    }
}
