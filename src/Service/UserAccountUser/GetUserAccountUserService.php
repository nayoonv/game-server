<?php

namespace App\Service\UserAccountUser;

use App\Exception\Login\UserAccountUserDBException;
use App\Infrastructure\Persistence\UserAccountUser\UserAccountUserDBRepository;

class GetUserAccountUserService
{
    private UserAccountUserDBRepository $userAccountUserDBRepository;

    public function __construct(UserAccountUserDBRepository $userAccountUserDBRepository) {
        $this->userAccountUserDBRepository = $userAccountUserDBRepository;
    }

    public function getHiveId($userId) {
        try {
            return $this->userAccountUserDBRepository->findHiveIdByUserId($userId);
        } catch (UserAccountUserDBException $e) {
            throw $e;
        }
    }
}