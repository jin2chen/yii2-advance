<?php

namespace console\controllers;

use common\domain\enums\UserStatusEnum;
use Faker\Factory;
use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\db\Connection;
use yii\di\Instance;

class FakerController extends Controller
{
    /**
     * @var string|Connection
     */
    public $db = 'db';
    /**
     * @var string
     */
    public $language;
    /**
     * @var \Faker\Generator
     */
    private $generator;


    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->db = Instance::ensure($this->db, Connection::class);
    }

    /**
     * @return \Faker\Generator
     */
    public function generator()
    {
        if ($this->generator === null) {
            $language = $this->language === null ? Yii::$app->language : $this->language;
            $this->generator = Factory::create(str_replace('-', '_', $language));
        }
        return $this->generator;
    }

    public function actionUser($count = 1)
    {
        ini_set('memory_limit', -1);
        for ($i = 0; $i < $count; $i++) {
            $faker = $this->generator();
            $timestamp = time();
            /** @noinspection PhpUnhandledExceptionInspection */
            $row = [
                'username' => $faker->unique()->userName,
                'auth_key' => Yii::$app->security->generateRandomString(),
                'password_hash' => '$2y$13$IpbH0O72.7cTgIOC2OvoHuQUky4Q3WkMI6CRjg.1IFxNyP6.VbdkG',
                'password_reset_token' => Yii::$app->security->generateRandomString(),
                'email' => $faker->unique()->firstName . '@jinchen.me',
                'status' => UserStatusEnum::active()->value(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];

            /** @noinspection PhpUnhandledExceptionInspection */
            $this->db->createCommand()->insert('user', $row)->execute();
        }
    }
}
