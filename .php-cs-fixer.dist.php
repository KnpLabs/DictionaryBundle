<?php

declare(strict_types=1);

use PedroTroller\CS\Fixer\Fixers;
use PedroTroller\CS\Fixer\RuleSetFactory;
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->append([__FILE__, __DIR__.'/.symfony_checker'])
;

$config = new Config();
$config->setFinder($finder);
$config->registerCustomFixers(new Fixers());
$config->setRiskyAllowed(true);
$config->setUsingCache(true);
$config->setRules(
    RuleSetFactory::create()
        ->phpCsFixer(true)
        ->php(8.1, true)
        ->pedrotroller(true)
        ->enable('align_multiline_comment')
        ->enable('array_indentation')
        ->enable('binary_operator_spaces', [
            'operators' => [
                '='  => 'align_single_space_minimal',
                '=>' => 'align_single_space_minimal',
            ],
        ])
        ->enable('global_namespace_import', ['import_classes' => true, 'import_constants' => false, 'import_functions' => false])
        ->enable('final_class')
        ->enable('ordered_imports')
        ->enable('ordered_interfaces')
        ->enable('phpdoc_line_span')
        ->disable('method_chaining_indentation')
        ->disable('no_break_comment')
        ->disable('no_superfluous_phpdoc_tags')
        ->disable('phpdoc_to_comment')
        ->getRules()
);

return $config;
