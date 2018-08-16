<?php

namespace api\domain\user;

class User
{
    private $id;
    private $username;
    private $email;
    private $authKey;
    private $passwordHash;
    private $passwordResetToken;
    private $status;
    private $createAt;
    private $updateAt;

    private function __construct()
    {
    }

    public static function fromAttributes($attributes)
    {
        $entity = new self();
        $entity->username = $attributes['username'];
        $entity->email = $attributes['email'];
    }
}
