<?php

namespace common\domain\enums;

use jinchen\enum\Enum;

/**
 * Class StatusEnum
 *
 * @method static $this active()
 * @method static $this deactive()
 */
class StatusEnum extends Enum
{
    public const ACTIVE = ['value' => 1, 'label' => 'active'];
    public const DEACTIVE = ['value' => 0, 'label' => 'deactive'];
}
