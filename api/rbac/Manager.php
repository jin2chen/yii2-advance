<?php

namespace api\rbac;

use api\domain\user\RoleEnum;
use BD\yii\modules\settings\Setting;
use InvalidArgumentException;
use yii\base\BaseObject;

final class Manager extends BaseObject
{
    /**
     * @var Setting
     */
    public $setting;
    /**
     * @var
     */
    public $config;

    /**
     * @var array
     */
    private $maps;
    /**
     * @var array
     */
    private $instances = [];

    /**
     * Detect whether the user have permission.
     *
     * @param string $code
     * @param RoleInterface $user
     * @param mixed ...$params
     * @return bool
     */
    public function isAllow(string $code, RoleInterface $user, ...$params)
    {
        $roleId = $user->roleId();
        ['map' => $map]= $this->maps($roleId);

        if (!isset($map[$code])) {
            return false;
        }
        if (is_bool($map[$code])) {
            return $map[$code];
        }

        return call_user_func_array([$this->instance($roleId, $user), $map[$code]], $params);
    }

    /**
     * @param int $id
     * @param RoleInterface $user
     * @return BaseStrategy
     */
    private function instance(int $id, RoleInterface $user)
    {
        if (!isset($this->instances[$id])) {
            ['class' => $class] = $this->maps($id);
            $instance = new $class($this->setting, $this->config, $user);
            $this->instances[$id] = $instance;
        }

        return $this->instances[$id];
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function maps(int $id)
    {
        if ($this->maps === null) {
            $this->maps = [
                RoleEnum::CLIENT['value'] => [
                    'map' => __DIR__ . '/roles/client/map.php',
                    'class' => 'api\rbac\roles\client\Strategy',
                ]
            ];
        }

        if (!isset($this->maps[$id])) {
            throw new InvalidArgumentException('Not config map for role id ' . $id);
        }

        if (is_string($this->maps[$id]['map'])) {
            /** @noinspection PhpIncludeInspection */
            $this->maps[$id]['map'] = require($this->maps[$id]['map']);
        }

        return $this->maps[$id];
    }
}
