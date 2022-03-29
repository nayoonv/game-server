<?php

namespace App\Service\Boat;

use App\Exception\Base\UrukException;
use App\Exception\Boat\UserBoatDBException;
use App\Exception\Boat\UserBoatNotExistsException;
use App\Infrastructure\Persistence\Boat\UserBoatDBRepository;

class GetUserBoatService
{
    private UserBoatDBRepository $userBoatDBRepository;
    public function __construct(UserBoatDBRepository $userBoatDBRepository) {
        $this->userBoatDBRepository = $userBoatDBRepository;
    }

    public function getUserBoat($userId) {
        try {
            return $this->userBoatDBRepository->findByUserId($userId);
        } catch(UrukException $e) {
            throw $e;
        }
    }
}