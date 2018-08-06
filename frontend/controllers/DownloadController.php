<?php

namespace frontend\controllers;

use frontend\commands\CqrsCommand;
use frontend\services\CqrsService;
use Yii;
use yii\db\Connection;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class DownloadController extends Controller
{

    /**
     * @param callable $execute
     * @param array $params
     * @return mixed
     * @throws \Throwable
     */
    public function execute(callable $execute, ...$params)
    {
        $callback = function () use ($execute, $params) {
            return $execute(...$params);
        };
        return Yii::$app->db->transaction($callback);
    }

    /**
     * @return Connection
     * @throws \yii\base\InvalidConfigException
     */
    public function getDb()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::$app->get('udb');
    }

    /**
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionStream()
    {
        $response = Yii::$app->response;
        $response->setDownloadHeaders('user-stream.csv', 'text/csv');
        $response->format = Response::FORMAT_RAW;
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

    /**
     * @return Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionFile()
    {
        $response = Yii::$app->response;
        $response->setDownloadHeaders('user-file.csv', 'text/csv');
        $response->format = Response::FORMAT_RAW;
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

    /**
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     * @throws \Throwable
     */
    public function actionCqrs()
    {
        // Validate command.
        $command = new CqrsCommand();
        $command->load(Yii::$app->request->post());
        if (!$command->validate()) {
            throw new BadRequestHttpException('Validate error.');
        }

        // Check permission.
        if (!Yii::$app->user->can('Download.Cqrs', $command)) {
            throw new ForbiddenHttpException('Not permission.');
        }

        // Execute logic.
        $service = new CqrsService();
        $result = $this->execute([$service, 'handleCqrs'], $command);

        // @TODO filter data for response.

        return $result;
    }
}
