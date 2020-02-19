<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;

if (Kernel::VERSION_ID >= 40308) {
    trait SymfonyCompatibilityTrait
    {
        /**
         * {@inheritdoc}
         */
        public function collect(Request $request, Response $response, \Throwable $exception = null): void
        {
        }
    }
} else {
    trait SymfonyCompatibilityTrait
    {
        /**
         * {@inheritdoc}
         */
        public function collect(Request $request, Response $response, \Exception $exception = null): void
        {
        }
    }
}
