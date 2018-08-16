<?php

namespace api\rbac;

use BD\yii\modules\settings\Setting;
use Noodlehaus\Config;
use yii\web\IdentityInterface;

class BaseStrategy
{
    /**
     * @var Setting
     */
    protected $setting;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var IdentityInterface
     */
    protected $identity;

    /**
     * BaseStrategy constructor.
     *
     * @param Setting $setting
     * @param Config $config
     * @param IdentityInterface $identity
     */
    public function __construct(Setting $setting, Config $config, IdentityInterface $identity)
    {
        $this->setting = $setting;
        $this->config = $config;
        $this->identity = $identity;
    }
}
