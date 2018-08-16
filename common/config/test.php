<?php
/** @noinspection SpellCheckingInspection */

return [
    'bootstrap' => ['log'],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => sprintf('mysql:host=%s;dbname=%s', env('TEST_DB_HOST'), env('TEST_DB_DATABASE')),
            'username' => env('TEST_DB_USERNAME'),
            'password' => env('TEST_DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'batchDb' => [
            'class' => 'yii\db\Connection',
            'dsn' => sprintf('mysql:host=%s;dbname=%s', env('TEST_DB_HOST'), env('TEST_DB_DATABASE')),
            'username' => env('TEST_DB_USERNAME'),
            'password' => env('TEST_DB_PASSWORD'),
            'charset' => 'utf8',
            'attributes' => [
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
            ],
        ],
    ]
];
