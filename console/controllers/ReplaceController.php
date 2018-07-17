<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Connection;
use yii\db\Query;

class ReplaceController extends Controller
{
    /**
     * @var string
     */
    protected $table = 'performance_log';

    /**
     * @return Connection
     * @throws \yii\base\InvalidConfigException
     */
    protected function getUdb()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::$app->get('rbc-udb');
    }

    /**
     * @return Connection
     * @throws \yii\base\InvalidConfigException
     */
    protected function getDb()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::$app->get('rbc-db');
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        $query = (new Query())->from($this->table);
        $pattern = '#/\d+(/|$)#';
        foreach ($query->each(1000, $this->getUdb()) as $row) {
            if (preg_match($pattern, $row['uri'])) {
                $row['uri'] = preg_replace($pattern, '/{id}/', $row['uri']);
                $command = $this->getDb()->createCommand()->update($this->table, ['uri' => $row['uri']], ['id' => $row['id']]);
                $command->execute();
                echo $command->getRawSql(), "\n";
            }
        }
    }
}
