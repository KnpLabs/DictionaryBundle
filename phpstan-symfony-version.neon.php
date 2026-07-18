<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;

return InstalledVersions::satisfies(new VersionParser(), 'symfony/config', '<7.4')
    ? ['parameters' => ['stubFiles' => [__DIR__.'/phpstan/stubs/TreeBuilder.stub']]]
    : [];
