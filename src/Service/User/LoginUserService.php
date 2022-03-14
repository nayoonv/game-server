<?php

namespace App\Service\User;

use App\Domain\User\User1;
use App\Infrastructure\Persistence\User\UserDBRepository;
use App\Service\UserAccountUser\LoginUserAccountUserService;

class LoginUserService
{
    private UserDBRepository $userDBRepository;
    private LoginUserAccountUserService $loginUserAccountUserService;
    public function __construct(UserDBRepository $userDBRepository, LoginUserAccountUserService $loginUserAccountUserService) {
        $this->userDBRepository = $userDBRepository;
        $this->loginUserAccountUserService = $loginUserAccountUserService;
    }

    public function findUser($hiveId): User1 {
        $userId = $this->loginUserAccountUserService->getUser($hiveId);
        $user = null;
        if ($userId == 0)
            $userId = $this->createUser($hiveId);

        $user = $this->userDBRepository->findByUserId($userId);

        return $user;
    }

    public function createUser($hiveId): int {
        return $this->userDBRepository->createUser($hiveId);
    }
}