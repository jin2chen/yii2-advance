<?php

namespace frontend\tests\helpers;

use Codeception\Module;
use Codeception\TestInterface;

class MyModule extends Module
{
    public function _before(TestInterface $test)
    {
        parent::_before($test);
        $this->debug('module before');
    }

    public function _after(TestInterface $test)
    {
        parent::_after($test);
        $this->debug('module after');
    }
}