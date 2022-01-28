<?php

declare(strict_types=1);

namespace Knp\DictionaryBundle\DataCollector\DictionaryDataCollector;

use Composer\InstalledVersions;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

switch ($version = substr((string) InstalledVersions::getVersion('symfony/http-kernel'), 0, 3)) {
    default:
        throw new Exception('knplabs/dictionary-bundle is not compatible with the current version of symfony/http-kernel: '.$version);

    case '6.0':
    case '5.4':
        trait SymfonyCompatibilityTrait
        {
            public function collect(Request $request, Response $response, Throwable $exception = null): void
            {
            }
        }

        break;

    case '4.4':
        trait SymfonyCompatibilityTrait
        {
            public function collect(Request $request, Response $response/*, \Throwable $exception = null*/): void
            {
            }
        }

        break;
}
