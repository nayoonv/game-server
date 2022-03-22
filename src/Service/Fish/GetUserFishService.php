<?php

namespace App\Service\Fish;

use App\Infrastructure\Persistence\Fish\UserFishDBException;
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
    public function getUserFishNotInUserBook($userId) {
        return $this->userFishDBRepository->findNotInUserBookByUserId($userId);
    }
    public function getUserFish($userFishId) {
        try {
            return $this->userFishDBRepository->findByUserFishId($userFishId);
        } catch(UserFishDBException $e) {
            throw $e;
        }
    }
}