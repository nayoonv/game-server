<?php

namespace App\Service\UserAccountUser;

use App\Exception\Base\UrukException;
use App\Infrastructure\Persistence\UserAccountUser\UserAccountUserDBRepository;

class LoginUserAccountUserService
{
    private UserAccountUserDBRepository $userAccountUserDBRepository;

    public function __construct(UserAccountUserDBRepository $userAccountUserDBRepository) {
        $this->userAccountUserDBRepository = $userAccountUserDBRepository;
    }

    public function getUser($hiveId): int {
        try {
            return $this->userAccountUserDBRepository->findUserIdByHiveId($hiveId);
        } catch (UrukException $e) {
            throw $e;
        }
    }
}