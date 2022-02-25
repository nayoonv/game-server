<?php

namespace App\Service\UserAccount;

use App\Infrastructure\Persistence\UserAccount\UserAccountRepository;

class LoginUserAccountService
{
    private UserAccountRepository $userAccountRepository;

    public function __construct(UserAccountRepository $userAccountRepository) {
        $this->userAccountRepository = $userAccountRepository;
    }
    public function getUserInfo($hiveId) {
        return $this->userAccountRepository->findUserByHiveId($hiveId);
    }
}