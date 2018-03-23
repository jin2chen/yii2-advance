<?php

namespace common\rules;

class BaseRule
{
    const FUNC_STR_TO_LOWER = 'strtolower';
    const FUNC_INT_VAL = 'intval';

    const ID = 'id';
    const EMAIL = 'email';

    public static function id()
    {
        return [
            [self::ID, 'integer'],
            [self::ID, 'filter', 'filter' => self::FUNC_INT_VAL],
        ];
    }

    public static function email()
    {
        return [
            [self::EMAIL, 'email'],
            [self::EMAIL, 'trim'],
            [self::EMAIL, 'filter', 'filter' => self::FUNC_STR_TO_LOWER],
        ];
    }
}