<?php

namespace App\Service\User;

use App\Infrastructure\Persistence\User\UserDBRepository;

class GetUserService
{
    private UserDBRepository $userDBRepository;

    public function __construct(UserDBRepository $userDBRepository) {
        $this->userDBRepository = $userDBRepository;
    }

    public function getUserLevel($userId) {
        // 해당 유저가 없을 수도 있음
        return $this->userDBRepository->findLevelByUserId($userId);
    }
}