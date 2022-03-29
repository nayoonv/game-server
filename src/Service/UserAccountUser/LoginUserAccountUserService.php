<?php

namespace App\Service\UserAccountUser;

use App\Exception\Login\UserAccountUserDBException;
use App\Infrastructure\Persistence\UserAccountUser\UserAccountUserDBRepository;

class LoginUserAccountUserService
{
    private UserAccountUserDBRepository $userAccountUserDBRepository;

    public function __construct(UserAccountUserDBRepository $userAccountUserDBRepository) {
        $this->userAccountUserDBRepository = $userAccountUserDBRepository;
    }

    public function getUser($hiveId): int {
        try {
            $userId = $this->userAccountUserDBRepository->findUserIdByHiveId($hiveId);
        } catch (UserAccountUserDBException $e) {
            throw $e;
        }
        return $userId;
    }
}