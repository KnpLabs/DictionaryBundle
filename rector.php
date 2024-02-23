<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withPhpSets(php81: true)
    ->withPaths([__DIR__.'/src'])
;
