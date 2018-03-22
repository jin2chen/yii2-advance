<?php
namespace mole\yii\test\validators;

use Codeception\Test\Unit;
use Yii;

class EmbedManyValidatorTest extends Unit
{
    /**
     * @var \mole\yii\test\validators\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        codecept_debug(Yii::$aliases);
    }
}