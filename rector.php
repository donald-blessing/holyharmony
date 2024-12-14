<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\ClassMethod\ExplicitReturnNullRector;
use Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\Php83\Rector\ClassConst\AddTypeToConstRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use RectorLaravel\Rector\Class_\AnonymousMigrationsRector;
use RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector;
use RectorLaravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector;
use RectorLaravel\Rector\ClassMethod\MigrateToSimplifiedAttributeRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\Expr\SubStrToStartsWithOrEndsWithStaticMethodCallRector\SubStrToStartsWithOrEndsWithStaticMethodCallRector;
use RectorLaravel\Rector\FuncCall\NotFilledBlankFuncCallToBlankFilledFuncCallRector;
use RectorLaravel\Rector\FuncCall\NowFuncWithStartOfDayMethodCallToTodayFuncRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\FuncCall\ThrowIfAndThrowUnlessExceptionsToUseClassStringRector;
use RectorLaravel\Rector\FuncCall\TypeHintTappableCallRector;
use RectorLaravel\Rector\If_\ReportIfRector;
use RectorLaravel\Rector\If_\ThrowIfRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector;
use RectorLaravel\Rector\MethodCall\RedirectBackToBackHelperRector;
use RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector;
use RectorLaravel\Rector\MethodCall\ReverseConditionableMethodCallRector;
use RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector;
use RectorLaravel\Rector\Namespace_\FactoryDefinitionRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/database',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withSkipPath(__DIR__.'/app/Providers')
    ->withSkipPath(__DIR__.'/database/migrations')
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_110,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        LaravelSetList::LARAVEL_IF_HELPERS,
        //        LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        instanceOf: true,
        earlyReturn: true,
        strictBooleans: true,
        carbon: true,
    )
    ->withRules([
        RedirectRouteToToRouteHelperRector::class,
        TypedPropertyFromStrictConstructorRector::class,
        AddLiteralSeparatorToNumberRector::class,
        AddGenericReturnTypeToRelationsRector::class,
        EloquentMagicMethodToQueryBuilderRector::class,
        AnonymousMigrationsRector::class,
        AddTypeToConstRector::class,
        AddParentBootToModelClassMethodRector::class,
        MigrateToSimplifiedAttributeRector::class,
        EloquentOrderByToLatestOrOldestRector::class,
        EloquentWhereRelationTypeHintingParameterRector::class,
        EloquentWhereTypeHintClosureParameterRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        FactoryDefinitionRector::class,
        NotFilledBlankFuncCallToBlankFilledFuncCallRector::class,
        NowFuncWithStartOfDayMethodCallToTodayFuncRector::class,
        RedirectBackToBackHelperRector::class,
        RemoveDumpDataDeadCodeRector::class,
        ReportIfRector::class,
        ReverseConditionableMethodCallRector::class,
        RouteActionCallableRector::class,
        SubStrToStartsWithOrEndsWithStaticMethodCallRector::class,
        ThrowIfRector::class,
        ThrowIfAndThrowUnlessExceptionsToUseClassStringRector::class,
        TypeHintTappableCallRector::class,
        ValidationRuleArrayStringValueToArrayRector::class,
    ])
    ->withSkip([
        EncapsedStringsToSprintfRector::class,
        IssetOnPropertyObjectToPropertyExistsRector::class,
        SeparateMultiUseImportsRector::class,
        ExplicitReturnNullRector::class,
        RemoveDeadTryCatchRector::class,
    ])
    ->withImportNames();
