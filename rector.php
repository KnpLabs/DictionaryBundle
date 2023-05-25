<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig
        ->paths(
            [
                __DIR__.'/src',
            ]
        )
    ;

    $rectorConfig
        ->phpVersion(
            PhpVersion::PHP_80
        )
    ;

    $rectorConfig
        ->sets(
            [
                LevelSetList::UP_TO_PHP_80,
                SetList::CODE_QUALITY,
                SetList::DEAD_CODE,
            ]
        )
    ;
};
