<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use SlevomatCodingStandard\Sniffs\Commenting\DisallowCommentAfterCodeSniff;
use SlevomatCodingStandard\Sniffs\Commenting\EmptyCommentSniff;
use SlevomatCodingStandard\Sniffs\Commenting\ForbiddenAnnotationsSniff;
use SlevomatCodingStandard\Sniffs\Commenting\ForbiddenCommentsSniff;
use SlevomatCodingStandard\Sniffs\Commenting\InlineDocCommentDeclarationSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\AssignmentInConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\LanguageConstructWithParenthesesSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\NewWithParenthesesSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireNullCoalesceOperatorSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\DeadCatchSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\ReferenceThrowableOnlySniff;
use SlevomatCodingStandard\Sniffs\Namespaces\DisallowGroupUseSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedClassNameInAnnotationSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\MultipleUsesPerLineSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\ReferenceUsedNamesOnlySniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UnusedUsesSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UseDoesNotStartWithBackslashSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UseFromSameNamespaceSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UseSpacingSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\LongTypeHintsSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\NullableTypeForNullDefaultValueSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSpacingSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSpacingSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\Annotation\RemovePHPStormAnnotationFixer;
use Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SETS, [
        SetList::PSR_12,
        SetList::COMMON,
    ]);

    $parameters->set(Option::PATHS, [
        __DIR__ . '/app',
        __DIR__ . '/tests',
    ]);

    $parameters->set(Option::SKIP, [
        __DIR__ . '/routes/api.php',
        PhpUnitStrictFixer::class => null,
        // enable later
        StrictComparisonFixer::class => null,
        StrictParamFixer::class => null,
    ]);

    $parameters->set(Option::ONLY, [
        PhpUnitStrictFixer::class => null,
        // enable later
        StrictComparisonFixer::class => null,
        StrictParamFixer::class => null,
        ReferenceThrowableOnlySniff::class => [
            __DIR__ . '/app/Exceptions/Handler.php',
        ],
        // many false positives and too much magic in the code
        InlineDocCommentDeclarationSniff::class => null,
        // way to many cases
        DisallowCommentAfterCodeSniff::class . '.DisallowedCommentAfterCode' => null,

        ReferenceUsedNamesOnlySniff::class => [
            __DIR__ . '/app',
            __DIR__ . '/tests/Unit',
            __DIR__ . '/tests/helpers',
        ],
    ]);

    $services = $containerConfigurator->services();

    $services->set(ReferenceUsedNamesOnlySniff::class)
        ->property('searchAnnotations', true)
        ->property('allowFallbackGlobalFunctions', true)
        ->property('allowFallbackGlobalConstants', true)
        ->property('allowPartialUses', false);

    // same as SetList::DOCBLOCK, just one rule by one, as there was -40 k lines :D
    $services->set(NoSuperfluousPhpdocTagsFixer::class)
        ->call('configure', [[
            'remove_inheritdoc' => false,
            'allow_mixed' => true,
        ]]);
//    $services->set(RemoveSuperfluousDocBlockWhitespaceFixer::class);
    $services->set(NoEmptyPhpdocFixer::class);
    $services->set(PhpdocTrimFixer::class);
    $services->set(RemovePHPStormAnnotationFixer::class);

    $services->set(EncodingFixer::class);
    $services->set(EmptyCommentSniff::class);
    $services->set(UseSpacingSniff::class);

    // pre-ECS Rewards ruleset
    $services->set(ReferenceThrowableOnlySniff::class);
    $services->set(NullableTypeForNullDefaultValueSniff::class);

    // former PHP_CodeSniffer ruleset.xml
    $services->set(UnusedUsesSniff::class);
    $services->set(AssignmentInConditionSniff::class);
    $services->set(LanguageConstructWithParenthesesSniff::class);
    $services->set(NewWithParenthesesSniff::class);
    $services->set(MultipleUsesPerLineSniff::class);
    $services->set(UseDoesNotStartWithBackslashSniff::class);
    $services->set(UseFromSameNamespaceSniff::class);
    $services->set(LongTypeHintsSniff::class);
    $services->set(InlineDocCommentDeclarationSniff::class);
    $services->set(ForbiddenCommentsSniff::class);
    $services->set(ForbiddenAnnotationsSniff::class);
    $services->set(RequireNullCoalesceOperatorSniff::class);
    $services->set(DeadCatchSniff::class);
    $services->set(ReferenceThrowableOnlySniff::class);
    $services->set(DisallowGroupUseSniff::class);
    $services->set(FullyQualifiedClassNameInAnnotationSniff::class);

    $services->set(NullableTypeForNullDefaultValueSniff::class);
    $services->set(ParameterTypeHintSpacingSniff::class);
    $services->set(ReturnTypeHintSpacingSniff::class);

    $services->set(ParamReturnAndVarTagMalformsFixer::class);
};
