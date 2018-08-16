<?php

namespace api\application\commands;

use yii\base\Model;

class CreateUserCommand extends Model
{
    public $username;
    public $password;
    public $email;
}
