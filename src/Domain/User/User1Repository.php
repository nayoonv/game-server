<?php

namespace App\Domain\User;

interface User1Repository
{
    public function findByHiveId(int $hiveId): User1;
}