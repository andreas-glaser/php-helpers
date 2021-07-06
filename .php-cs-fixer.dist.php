<?php


$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php');

$config = new PhpCsFixer\Config();
$config->setRiskyAllowed(true);
return $config->setRules([
    '@PSR12' => true,
    'strict_param' => true,
    '@Symfony' => true,
    '@DoctrineAnnotation' => true,
    'self_accessor' => true,
    'self_static_accessor' => true,
    'array_syntax' => ['syntax' => 'short'],
    'array_indentation' => true,
    'declare_strict_types' => false,
    'function_to_constant' => ['functions' => ['php_sapi_name']],
    'concat_space' => ['spacing' => 'one'],
    'cast_spaces' => false,
    'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
    'php_unit_no_expectation_annotation' => ['target' => 'newest'],
    'php_unit_expectation' => ['target' => 'newest'],
    'php_unit_dedicate_assert_internal_type' => ['target' => 'newest'],
    'no_empty_phpdoc' => true,
    'no_extra_blank_lines' => true,
    'no_empty_comment' => true,
    'no_trailing_whitespace_in_comment' => true,
    'single_line_comment_style' => true,
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'echo_tag_syntax' => [
        'format' => 'short'],
    'ordered_imports' => true,
    'no_superfluous_phpdoc_tags' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_unused_imports' => true,
    'general_phpdoc_annotation_remove' => [
        'annotations' => ['author']
    ],
    'php_unit_fqcn_annotation' => true,
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_trim' => true,
    'phpdoc_scalar' => true,
    'phpdoc_types' => true,
    'phpdoc_var_without_name' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_separation' => true,
    'phpdoc_align' => ['align' => 'vertical'],
    'visibility_required' => true,
    'binary_operator_spaces' => [
        'operators' => [
            '=>' => 'align_single_space_minimal',
        ]
    ],
    'native_function_invocation' => true,
])
    ->setFinder($finder);

