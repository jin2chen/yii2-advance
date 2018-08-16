<?php

namespace api\domain\user;

interface UserRepositoryInterface
{
    public function add(User $user);
}
