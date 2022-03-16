<?php

namespace App\Service\Map;

use App\Infrastructure\Persistence\Map\UserMapDBRepository;

class CreateUserMapService
{
    private UserMapDBRepository $userMapDBRepository;

    public function __construct(UserMapDBRepository $userMapDBRepository) {
        $this->userMapDBRepository = $userMapDBRepository;
    }

    public function createUserMap($userId) {
        try {
            $this->userMapDBRepository->createUserMap($userId);
        } catch (NotCreateUserMapException $exception) {

        }
    }
}