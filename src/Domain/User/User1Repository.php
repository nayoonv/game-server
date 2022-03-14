<?php

namespace App\Domain\User;

interface User1Repository
{
    public function findByUserId($userId): User1;
}