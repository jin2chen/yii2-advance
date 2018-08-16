<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Query;

class PdoController extends Controller
{
    public function actionBufferedQuery()
    {
        $query = (new Query())->from('user');
        foreach ($query->each() as $row) {
            echo $row['username'], "\n";
        }
        echo 'Peak: ', memory_get_peak_usage(), "\n";
    }

    public function actionUnbufferedQuery()
    {
        $unbufferedDb = new \yii\db\Connection([
            'dsn' => Yii::$app->db->dsn,
            'username' => Yii::$app->db->username,
            'password' => Yii::$app->db->password,
            'charset' => Yii::$app->db->charset,
        ]);
        /** @noinspection PhpUnhandledExceptionInspection */
        $unbufferedDb->open();
        $unbufferedDb->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);

        $query = (new Query())->from('user');
        foreach ($query->each(10000, $unbufferedDb) as $row) {
            echo $row['username'], "\n";
        }
        echo 'Peak: ', memory_get_peak_usage(), "\n";
    }

    public function actionConnection($count = 2)
    {
        $all = [];
        for ($i = 0; $i < $count; $i++) {
            $db = new \yii\db\Connection([
                'dsn' => Yii::$app->db->dsn,
                'username' => Yii::$app->db->username,
                'password' => Yii::$app->db->password,
                'charset' => Yii::$app->db->charset,
            ]);
            /** @noinspection PhpUnhandledExceptionInspection */
            $db->open();
            $all[] = $db;
            sleep(5);
        }

        sleep(20);
    }
}
