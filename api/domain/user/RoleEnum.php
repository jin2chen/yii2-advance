<?php

namespace api\domain\user;

use jinchen\enum\Enum;

class RoleEnum extends Enum
{
    public const CLIENT = ['value' => 1, 'label' => 'Client'];
    public const CS = ['value' => 2, 'label' => 'Credit Associate'];
}
