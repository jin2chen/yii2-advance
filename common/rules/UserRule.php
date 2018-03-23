<?php

namespace common\rules;

class UserRule extends BaseRule
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public static function status()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
}