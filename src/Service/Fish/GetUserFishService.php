<?php

namespace App\Service\Fish;

use App\Exception\Base\UrukException;
use App\Infrastructure\Persistence\Fish\UserFishDBRepository;

class GetUserFishService
{
    private UserFishDBRepository $userFishDBRepository;
    public function __construct(UserFishDBRepository $userFishDBRepository) {
        $this->userFishDBRepository = $userFishDBRepository;
    }

    // 정산
    public function getUserFishWhileFishing($userId){
        try {
            return $this->userFishDBRepository->findBeforeCalUnchecked($userId);
        } catch (UrukException $e) {
            throw $e;
        }
    }
    //
    public function getUserFishNotInUserBook($userId) {
        try {
            return $this->userFishDBRepository->findNotInUserBookByUserId($userId);
        } catch (UrukException $e) {
            throw $e;
        }
    }
    public function getUserFish($userFishId) {
        try {
            return $this->userFishDBRepository->findByUserFishId($userFishId);
        } catch(UrukException $e) {
            throw $e;
        }
    }
}