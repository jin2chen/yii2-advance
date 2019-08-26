<?php
/** @noinspection SpellCheckingInspection */

use Noodlehaus\Config;
use yii\queue\db\Queue;
use yii\queue\ExecEvent;

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'container' => [
    ],
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
            'traceLevel' => env('APP_LOG_TRACE_LEVEL', 0),
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
            'useFileTransport' => true,
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('MAIL_SMTP_HOST'),
                'username' => env('MAIL_SMTP_USER'),
                'password' => env('MAIL_SMTP_PASSWORD'),
                'port' => '587',
                'encryption' => 'tls',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'ruleService' => [
            'class' => 'jinchen\rule\RuleService',
        ],
        'config' => function () {
            return new Config(__DIR__ . '/params.php');
        },
        'queue' => [
            'class' => 'yii\queue\db\Queue',
            'mutex' => 'yii\mutex\MysqlMutex',
            'deleteReleased' => false,
            'on afterError' => function (ExecEvent $event) {
                /** @var Queue $queue */
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
