<?php

namespace App\Service\Boat;

use App\Infrastructure\Persistence\Boat\UserBoatDBRepository;

class GetUserBoatService
{
    private UserBoatDBRepository $userBoatDBRepository;
    public function __construct(UserBoatDBRepository $userBoatDBRepository) {
        $this->userBoatDBRepository = $userBoatDBRepository;
    }
    public function getUserBoat($userId) {
        return $this->userBoatDBRepository->findByUserId($userId);
    }
}