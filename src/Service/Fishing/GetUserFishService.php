<?php

namespace App\Service\Fishing;

use App\Infrastructure\Persistence\Fish\UserFishDBRepository;

class GetUserFishService
{
    private UserFishDBRepository $userFishDBRepository;
    public function __construct(UserFishDBRepository $userFishDBRepository) {
        $this->userFishDBRepository = $userFishDBRepository;
    }
    public function getUserFishWhileFishing($userId){
        $userFishList = $this->userFishDBRepository->findBeforeCalUnchecked($userId);
        return $userFishList;
    }
}