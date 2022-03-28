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
        try {
            return $this->userFishDBRepository->findBeforeCalUnchecked($userId);
        } catch (UserFishDBException $e) {
            throw $e;
        }
    }
    public function getUserFishNotInUserBook($userId) {
        try {
            return $this->userFishDBRepository->findNotInUserBookByUserId($userId);
        } catch (UserFishDBException $e) {
            throw $e;
        }
    }
    public function getUserFish($userFishId) {
        try {
            return $this->userFishDBRepository->findByUserFishId($userFishId);
        } catch(UserFishDBException $e) {
            throw $e;
        }
    }
}