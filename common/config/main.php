<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => ['queue'],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
