<?php
declare(strict_types = 1);

namespace common\domain\rules;

/**
 * Class BaseRule
 */
class BaseRule
{
    const FUNC_STR_TO_LOWER = 'strtolower';
    const FUNC_INT_VAL = 'intval';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * BaseRule constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * @param string $field
     * @return array
     */
    public function idPattern(string $field): array
    {
        return [
            'integer' => [$field, 'integer'],
            'intval' => [$field, 'filter', 'filter' => self::FUNC_INT_VAL],
        ];
    }

    /**
     * @param string $field
     * @return array
     */
    public function emailPattern(string $field): array
    {
        return [
            'email' => [$field, 'email'],
            'trim' => [$field, 'trim'],
            'strToLower' => [$field, 'filter', 'filter' => self::FUNC_STR_TO_LOWER],
        ];
    }
}
