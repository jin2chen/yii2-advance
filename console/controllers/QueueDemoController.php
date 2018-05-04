<?php

namespace console\controllers;

use common\jobs\Welcome;
use Faker\Factory;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\queue\Queue;

class QueueDemoController extends Controller
{
    /**
     * Send a welcome queue.
     *
     * @param int $count
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    public function actionWelcome($count = 1)
    {
        /** @var Queue $queue */
        $queue = Yii::$app->get('queue');
        $faker = Factory::create();
        for ($i = 0; $i < $count; ++$i) {
            $queue->push(new Welcome($faker->unique()->name));
        }

        return ExitCode::OK;
    }
}
