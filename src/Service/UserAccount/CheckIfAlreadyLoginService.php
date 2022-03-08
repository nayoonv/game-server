<?php

namespace App\Service\UserAccount;

use App\Infrastructure\Persistence\UserAccount\UserAccountInMemoryRepository;

class CheckIfAlreadyLoginService
{
    private UserAccountInMemoryRepository $userAccountInMemoryRepository;

    public function __construct(UserAccountInMemoryRepository $userAccountInMemoryRepository) {
        $this->userAccountInMemoryRepository = $userAccountInMemoryRepository;
    }

    public function isExists($userId): string {
        return $this->userAccountInMemoryRepository->findSessionKeyByUserId(strval($userId));
    }

    public function setSessionKey($userId, $sessionKey): string {
        return $this->userAccountInMemoryRepository->insertUserIdAndSessionKey($userId, $sessionKey);
    }

}