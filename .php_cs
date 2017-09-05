<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__)
    ->exclude('vendor')
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array(
        'align_double_arrow',
        'align_equals',
        'combine_consecutive_unsets',
        'concat_with_spaces',
        'line_break_between_statements',
        'logical_not_operators_with_spaces',
        'newline_after_open_tag',
        'no_empty_comment',
        'no_empty_comment',
        'no_useless_return',
        'no_useless_return',
        'ordered_use',
        'phpdoc_order',
        'phpspec',
        'long_array_syntax',
    ))
    ->addCustomFixer(new PedroTroller\CS\Fixer\Contrib\LineBreakBetweenStatementsFixer())
    ->addCustomFixer(new PedroTroller\CS\Fixer\Contrib\PhpspecFixer())
    ->finder($finder)
;
