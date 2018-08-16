<?php

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    [
        'id' => 'app-api',
        'name' => env('API_NAME'),
        'basePath' => dirname(__DIR__),
        'controllerNamespace' => 'api\controllers',
        'on beforeRequest' => function ($event) {
            /** @var \yii\base\Event $event */
            /** @var \yii\web\Application $sender */
            $sender = $event->sender;
            $request = $sender->getRequest();
            $response = $sender->getResponse();
            $url = $request->getUrl();

            if (strncasecmp('/debug', $url, 6) === 0) {
                $response->format = \yii\web\Response::FORMAT_HTML;
            } else {
                $response->format = \yii\web\Response::FORMAT_JSON;
            }
        },
        'components' => [
            'request' => [
                'enableCsrfValidation' => false,
            ],
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'enableStrictParsing' => true,
                'rules' => [
                    [
                        'class' => 'yii\web\GroupUrlRule',
                        'prefix' => 'users',
                        'routePrefix' => '',
                        'rules' => [
                            'GET ' => 'user/index',
                            'POST ' => 'user/create',
                            'GET <id:\d+>' => 'user/view'
                        ]
                    ]
                ],
            ],
        ]
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
}

return $config;
