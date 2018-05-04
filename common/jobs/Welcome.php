<?php

namespace common\jobs;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\RetryableJobInterface;

class Welcome extends BaseObject implements JobInterface, RetryableJobInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Welcome constructor.
     *
     * @param string $name
     * @param array $config
     */
    public function __construct($name, array $config = [])
    {
        parent::__construct($config);

        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        Yii::info(sprintf('PID %s, Welcome %s', getmypid(), $this->name), __METHOD__);
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 30;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return true;
    }
}
