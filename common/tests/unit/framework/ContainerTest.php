<?php

namespace common\tests\unit\framework;

use Codeception\Test\Unit;
use common\tests\unit\framework\assets\UserController;
use common\tests\unit\framework\assets\UserService;
use Yii;
use yii\db\Connection;
use yii\web\Controller;

class ContainerTest extends Unit
{
    private function definitions()
    {
        return [
            'yii\db\Connection' => [
                'username' => 'mole',
                'password' => 'mole',
            ],
            'common\tests\unit\framework\assets\UserService',
        ];
    }

    public function setUp()
    {
        Yii::$container->setSingletons($this->definitions());
    }

    public function tearDown()
    {
        foreach ($this->definitions() as $key => $val) {
            if (is_int($key)) {
                $key = $val;
            }

            Yii::$container->clear($key);
        }
    }

    /**
     * @test
     */
    public function inject()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var UserService $service */
        $service = Yii::createObject(UserService::class);
        $db = $service->db();
        $this->assertInstanceOf(Connection::class, $db);
        $this->assertEquals('mole', $db->username);
        $this->assertEquals('mole', $db->password);
    }

    /**
     * @test
     */
    public function controller()
    {
        Yii::$app->controllerMap['user'] = UserController::class;
        /** @var $controller UserController */
        /** @noinspection PhpUnhandledExceptionInspection */
        [$controller] = Yii::$app->createController('user/create');
        $this->assertInstanceOf(Controller::class, $controller);
        $this->assertInstanceOf(UserService::class, $controller->create());
        $this->assertInstanceOf(Connection::class, $controller->create()->db());
    }
}
