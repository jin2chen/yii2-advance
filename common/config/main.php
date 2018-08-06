<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => ['log', 'queue'],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => sprintf('mysql:host=%s;dbname=%s', env('DB_HOST'), env('DB_DATABASE')),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'batchDb' => [
            'class' => 'yii\db\Connection',
            'dsn' => sprintf('mysql:host=%s;dbname=%s', env('DB_HOST'), env('DB_DATABASE')),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
            'attributes' => [
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                    'logVars' => [],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'ruleService' => [
            'class' => 'jinchen\rule\RuleService',
        ],
        'queue' => [
            'class' => 'yii\queue\db\Queue',
            'mutex' => 'yii\mutex\MysqlMutex',
            'deleteReleased' => false,
            'on afterError' => function (\yii\queue\ExecEvent $event) {
                /** @var \yii\queue\db\Queue $queue */
                $queue = Yii::$app->get('queue');
                Yii::$app->db->createCommand()
                    ->update(
                        $queue->tableName,
                        ['ttr' => pow(2, (int) $event->attempt)],
                        ['id' => $event->id]
                    )
                    ->execute();
            }
        ]
    ],
];
