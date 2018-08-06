<?php
declare(strict_types = 1);

namespace common\domain\rules;

use common\domain\enums\UserStatusEnum;

class UserRule extends BaseRule
{
    public function status()
    {
        return [
            'default' => ['status', 'default', 'value' => UserStatusEnum::active()->value()],
            'in' => ['status', 'in', 'range' => UserStatusEnum::values()],
        ];
    }
}
