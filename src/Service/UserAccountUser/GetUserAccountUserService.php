<?php

namespace App\Service\UserAccountUser;

use App\Infrastructure\Persistence\UserAccountUser\UserAccountUserDBException;
use App\Infrastructure\Persistence\UserAccountUser\UserAccountUserDBRepository;

class GetUserAccountUserService
{
    private UserAccountUserDBRepository $userAccountUserDBRepository;

    public function __construct(UserAccountUserDBRepository $userAccountUserDBRepository) {
        $this->userAccountUserDBRepository = $userAccountUserDBRepository;
    }

    public function getHiveId($userId) {
        try {
            $hiveId = $this->userAccountUserDBRepository->findHiveIdByUserId($userId);
        } catch (UserAccountUserDBException $e) {
            throw $e;
        }
        return $hiveId;
    }
}