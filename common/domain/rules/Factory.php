<?php
declare(strict_types = 1);

namespace common\domain\rules;

/**
 * Class Factory
 */
final class Factory
{
    /**
     * @var BaseRule[]
     */
    private static $instances = [];

    /**
     * @param string $class
     * @param array $params
     * @return BaseRule
     */
    public static function create(string $class, array $params = []): BaseRule
    {
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class($params);
        }

        return self::$instances[$class];
    }
}
