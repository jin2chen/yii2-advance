<?php
/** @noinspection SpellCheckingInspection */

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    [
        'id' => 'app-backend',
        'name' => env('BACKEND_NAME'),
        'basePath' => dirname(__DIR__),
        'controllerNamespace' => 'backend\controllers',
        'components' => [
            'request' => [
                'csrfParam' => 'bcsrf',
                'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            ],
            'user' => [
                'identityClass' => 'common\models\User',
                'enableAutoLogin' => true,
                'identityCookie' => ['name' => 'bid', 'httpOnly' => true],
            ],
            'session' => [
                'name' => 'bs',
            ],
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                ],
            ],
        ],
    ]
);

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['components']['view'] = [
        'on beginBody' => function ($event) {
            if (class_exists('yii\debug\Module', false)) {
                $event->sender->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
            }
        }
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
