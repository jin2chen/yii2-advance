<?php

return [
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
];
