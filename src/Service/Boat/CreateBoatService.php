<?php

namespace App\Service\Boat;

use App\Infrastructure\Persistence\Boat\UserBoatDBRepository;

class CreateBoatService
{
    private UserBoatDBRepository $userBoatDBRepository;

    public function __construct(UserBoatDBRepository $userBoatDBRepository) {
        $this->userBoatDBRepository = $userBoatDBRepository;
    }

    public function createUserBoat($userId) {
        try {
            $this->userBoatDBRepository->createUserBoat($userId);
        } catch (NotCreateUserBoatException $exception) {
            throw $exception;
        }
    }
}