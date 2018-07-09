<?php

namespace frontend\controllers;

use Yii;
use yii\db\Connection;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Response;

class DownloadController extends Controller
{

    /**
     * @return Connection
     * @throws \yii\base\InvalidConfigException
     */
    public function getDb()
    {
       return Yii::$app->get('udb');
    }

    public function actionStream()
    {
        $response = Yii::$app->response;
        $response->setDownloadHeaders('user-stream.csv', 'text/csv');
        $response->format  = Response::FORMAT_RAW;
        $response->send();

        $fp = fopen('php://output', 'w');
        $query = (new Query())->from('user')->limit(50000);
        $i = 0;
        foreach ($query->each(10000, $this->getDb()) as $row) {
            fputcsv($fp, $row);
            if (++$i % 1000 == 0) {
//                ob_flush();
//                flush();
                sleep(2);
            }
        }
        fclose($fp);

        return $response;
    }

    public function actionFile()
    {
        $response = Yii::$app->response;
        $response->setDownloadHeaders('user-file.csv', 'text/csv');
        $response->format  = Response::FORMAT_RAW;
        $response->send();
        ob_flush();
        flush();

        $fp = tmpfile();
        $query = (new Query())->from('user')->limit(50000);
        $i = 0;
        foreach ($query->each(10000, $this->getDb()) as $row) {
            fputcsv($fp, $row);
//            echo ' ';
            if (++$i % 1000 == 0) {
                sleep(2);
                ob_flush();
                flush();
            }
        }

//        echo "\n";
        rewind($fp);
        fpassthru($fp);
        return $response;
    }
}
