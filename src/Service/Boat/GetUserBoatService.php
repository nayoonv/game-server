<?php

namespace App\Service\Boat;

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
            $result = $this->userBoatDBRepository->findByUserId($userId);

            if (!$result)
                throw new UserBoatNotExistsException();

            return $result;
        } catch(UserBoatDBException | UserBoatNotExistsException $e) {
            throw $e;
        }
    }
}