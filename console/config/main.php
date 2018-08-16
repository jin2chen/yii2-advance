<?php

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    [
        'id' => 'app-console',
        'basePath' => dirname(__DIR__),
        'bootstrap' => ['log', 'queue'],
        'controllerNamespace' => 'console\controllers',
        'controllerMap' => [
            'fixture' => [
                'class' => 'yii\console\controllers\FixtureController',
                'namespace' => 'common\fixtures',
            ],
            'migrate' => [
                'class' => 'yii\console\controllers\MigrateController',
                'migrationNamespaces' => [
                    'yii\queue\db\migrations',
                ]
            ]
        ],
        'components' => [
            'errorHandler' => [
                'memoryReserveSize' => 1 * 1024 * 1024
            ],
        ],
    ]
);

return $config;
