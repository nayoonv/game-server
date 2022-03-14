<?php

namespace App\Service\UserAccountUser;

use App\Infrastructure\Persistence\UserAccountUser\UserAccountUserDBRepository;
use App\Service\User\CreateUserService;

class LoginUserAccountUserService
{
    private UserAccountUserDBRepository $userAccountUserDBRepository;

    public function __construct(UserAccountUserDBRepository $userAccountUserDBRepository) {
        $this->userAccountUserDBRepository = $userAccountUserDBRepository;
    }

    public function getUser($hiveId): int {
        return $this->userAccountUserDBRepository->findUserIdByHiveId($hiveId);
    }
}