<?php

namespace App\Service\User;

use App\Infrastructure\Persistence\User\UserDBException;
use App\Infrastructure\Persistence\User\UserDBRepository;

class UpdateUserService
{
    private UserDBRepository $userDBRepository;

    public function __construct(UserDBRepository $userDBRepository) {
        $this->userDBRepository = $userDBRepository;
    }

    public function updateUserAsset($userId, $assetType, $cost) {
        try {
            switch ($assetType) {
                case 1:
                    $this->userDBRepository->updateGold($userId, $cost);
                    break;
                case 2:
                    $this->userDBRepository->updateFatigue($userId, $cost);
                    break;
                case 3:
                    $this->userDBRepository->updatePearl($userId, $cost);
                    break;
            }
        } catch(UserDBException $e) {
            throw $e;
        }
    }
}