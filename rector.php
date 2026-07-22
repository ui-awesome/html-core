<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->import(__DIR__ . '/vendor/php-forge/coding-standard/src/rector-83.php');

    $rectorConfig->skip([AddOverrideAttributeToOverriddenMethodsRector::class]);

    $rectorConfig->importNames();

    $rectorConfig->paths(
        [
            __DIR__ . '/src',
            __DIR__ . '/tests',
        ],
    );
};
