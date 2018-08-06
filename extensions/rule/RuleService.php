<?php
declare(strict_types = 1);

namespace jinchen\rule;

use common\domain\rules\BaseRule;
use common\domain\rules\Factory;
use yii\base\Component;

/**
 * Class RuleService
 */
class RuleService extends Component
{
    /**
     * @var array
     */
    public $params = [];

    /**
     * @param string $class
     * @return BaseRule
     */
    public function get(string $class)
    {
        return Factory::create($class, $this->params);
    }
}
