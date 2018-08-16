<?php

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/../../common/config/test.php',
    [
        'id' => 'app-frontend-tests',
        'components' => [
            'assetManager' => [
                'basePath' => __DIR__ . '/../web/assets',
            ],
            'urlManager' => [
                'showScriptName' => true,
            ],
        ],
    ]
);

return $config;
