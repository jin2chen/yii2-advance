<?php

namespace common\tests\unit\framework\assets;

use yii\base\Module;
use yii\web\Controller;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(string $id, Module $module, UserService $userService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
    }

    public function create()
    {
        return $this->userService;
    }
}
