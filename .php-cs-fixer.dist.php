<?php

//$header = <<<'EOF'
//This file is part of Little Bookkeeping Project.
//Developed By Shawly
//
//@link     https://www.shawly.cn
//$contact  liber@shawly.cn
//EOF;

$rules = [
    '@Symfony'                               => true,
    '@PhpCsFixer'                            => true,
    'array_syntax'                           => ['syntax' => 'short'],
    'multiline_whitespace_before_semicolons' => false,
    //    'header_comment' => [
    //        'comment_type' => 'PHPDoc',
    //        'header' => $header,
    //        'separate' => 'none',
    //        'location' => 'after_declare_strict',
    //    ],
    'echo_tag_syntax'                   => ['format' => 'long'],
    'no_unused_imports'                 => true,
    'not_operator_with_successor_space' => true,
    'phpdoc_no_empty_return'            => false,
    'phpdoc_align'                      => [
        'align' => 'left',
    ],
    'phpdoc_separation'           => false,
    'linebreak_after_opening_tag' => true,
    'ordered_imports'             => [
        'imports_order' => [
            'class', 'function', 'const',
        ],
        'sort_algorithm' => 'alpha',
    ],
    'blank_line_after_opening_tag'    => true,
    'trim_array_spaces'               => true,
    'braces'                          => ['allow_single_line_closure' => true],
    'compact_nullable_typehint'       => true,
    'concat_space'                    => ['spacing' => 'one'],
    'declare_equal_normalize'         => ['space' => 'none'],
    'function_typehint_space'         => true,
    'new_with_braces'                 => true,
    'method_argument_space'           => ['on_multiline' => 'ensure_fully_multiline'],
    'no_empty_statement'              => true,
    'no_leading_import_slash'         => true,
    'no_leading_namespace_whitespace' => true,
    'no_whitespace_in_blank_line'     => true,
    //    'no_superfluous_phpdoc_tags' => [
    //        'allow_mixed' => true,
    //        'remove_inheritdoc' => false,
    //        'allow_unused_params' => true,
    //    ],
    'no_superfluous_phpdoc_tags' => false,
    'no_empty_comment'           => false,
    //    'no_extra_blank_lines' => false,
    'return_type_declaration'           => ['space_before' => 'none'],
    'single_trait_insert_per_statement' => true,
    'binary_operator_spaces'            => [
        'default' => 'align_single_space_minimal',
    ],
    'encoding'    => true,
    'list_syntax' => [
        'syntax' => 'short',
    ],
    'blank_line_before_statement' => [
        'statements' => [
            'declare', 'return',
        ],
    ],
    'single_line_comment_style' => [
        'comment_types' => [
        ],
    ],
    'constant_case' => [
        'case' => 'lower',
    ],
    'class_attributes_separation'       => true,
    'combine_consecutive_unsets'        => true,
    'lowercase_static_reference'        => true,
    'no_useless_else'                   => true,
    'not_operator_with_space'           => false,
    'ordered_class_elements'            => true,
    'php_unit_strict'                   => false,
    'single_quote'                      => true,
    'standardize_not_equals'            => true,
    'multiline_comment_opening_closing' => true,
];

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->exclude([
        'bootstrap',
        'node_modules',
        'public',
        'resources/views',
        'scratch',
        'storage',
        'storage/views',
        'vendor',
    ])
    ->notPath([
        '.*.php',
        '*.blade.php',
        '*_ide_helper.php',
        'Controller.php',
        'server.php',
    ])
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();

return $config->setRules($rules)
    ->setUsingCache(false)
    ->setFinder($finder);
