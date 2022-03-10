<?php

namespace App\Service\UserAccount;

use App\Infrastructure\Persistence\UserAccount\UserAccountInMemoryRepository;

class CheckIfAlreadyLoginService
{
    private UserAccountInMemoryRepository $userAccountInMemoryRepository;

    public function __construct(UserAccountInMemoryRepository $userAccountInMemoryRepository) {
        $this->userAccountInMemoryRepository = $userAccountInMemoryRepository;
    }

    public function isExists($userId): bool {
        /*
            $redis->exists('key'); // 1
            $redis->exists('NonExistingKey'); // 0
        */
        return $this->userAccountInMemoryRepository->findSessionKeyByUserId(strval($userId)) == 1;
    }

    public function setSessionKey($userId, $sessionKey): string {
        return $this->userAccountInMemoryRepository->insertUserIdAndSessionKey($userId, $sessionKey);
    }

}