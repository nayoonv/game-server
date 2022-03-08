<?php

namespace App\Infrastructure\Persistence\UserAccount;

use App\Infrastructure\Persistence\Base\BaseInMemoryRepository;

class UserAccountInMemoryRepository extends BaseInMemoryRepository
{
    public function findSessionKeyByUserId($userId): string {
        return $this->redis->get($userId);
    }

    public function insertUserIdAndSessionKey($userId, $sessionKey): bool {
        $this->redis->set($userId, $sessionKey); // OK가 반환되면 return true
        return true;
    }
}