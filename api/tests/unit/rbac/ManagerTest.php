<?php

namespace api\tests\unit\rbac;

use api\rbac\Code;
use api\rbac\Manager;
use BD\yii\modules\settings\Setting;
use Codeception\Test\Unit;
use common\models\User;
use Noodlehaus\Config;
use Yii;

class ManagerTest extends Unit
{
    /**
     * @test
     */
    public function isAllow()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $manager = Yii::createObject([
            'class' => Manager::class,
            'setting' => $this->createMock(Setting::class),
            'config' => $this->createMock(Config::class),
        ]);

        $user = new User();
        $this->assertTrue($manager->isAllow(Code::APPLICATION_VIEW, $user));
    }
}
