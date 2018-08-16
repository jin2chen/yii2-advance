<?php

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    [
        'id' => 'app-frontend',
        'name' => env('FRONTEND_NAME'),
        'basePath' => dirname(__DIR__),
        'bootstrap' => ['log'],
        'controllerNamespace' => 'frontend\controllers',
        'components' => [
            'request' => [
                'csrfParam' => 'fcsrf',
                'csrfCookie' => [
                    'httpOnly' => true,
                    'secure' => COOKIE_SECURE,
                ],
                'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY'),
            ],
            'user' => [
                'identityClass' => 'common\models\User',
                'enableAutoLogin' => false,
                'identityCookie' => [
                    'name' => 'fuid',
                    'httpOnly' => true,
                    'secure' => COOKIE_SECURE,
                ],
            ],
            'session' => [
                'name' => 'fsid',
                'cookieParams' => [
                    'httpOnly' => true,
                    'secure' => COOKIE_SECURE,
                ]
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
