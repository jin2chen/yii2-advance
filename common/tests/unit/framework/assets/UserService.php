<?php

namespace common\tests\unit\framework\assets;

use yii\db\Connection;

class UserService
{
    /**
     * @var Connection
     */
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * @return Connection
     */
    public function db()
    {
        return $this->db;
    }
}
