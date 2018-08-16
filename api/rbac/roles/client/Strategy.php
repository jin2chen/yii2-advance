<?php

namespace api\rbac\roles\client;

use api\rbac\BaseStrategy;

class Strategy extends BaseStrategy
{
    public function applicationView()
    {
        return true;
    }

    public function applicationUpdate()
    {

    }
}
