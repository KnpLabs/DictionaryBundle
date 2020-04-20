<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Throwable;

switch (true) {
    case Kernel::VERSION_ID >= 50000:
        trait SymfonyCompatibilityTrait
        {
            public function collect(Request $request, Response $response, Throwable $exception = null): void
            {
            }
        }

        break;
    case Kernel::VERSION_ID < 50000:
        trait SymfonyCompatibilityTrait
        {
            public function collect(Request $request, Response $response/*, \Throwable $exception = null*/): void
            {
            }
        }

        break;
}
