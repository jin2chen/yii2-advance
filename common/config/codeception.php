<?php
/** @noinspection SpellCheckingInspection */

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/test.php',
    [
        'id' => 'app-common-tests',
        'basePath' => dirname(__DIR__),
        'runtimePath' => dirname(dirname(__DIR__)) . '/console/runtime',
        'components' => [
            'request' => [
                'cookieValidationKey' => 'tS83w8WkVltgk3fZyD1EO113GKDeb7fn82M6DNNsDq8c',
            ],
            'user' => [
                'class' => 'yii\web\User',
                'identityClass' => 'common\models\User',
            ],
        ],
    ]
);

return $config;
