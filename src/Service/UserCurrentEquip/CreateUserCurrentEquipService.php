<?php

namespace App\Service\UserCurrentEquip;

use App\Exception\Base\UrukException;
use App\Infrastructure\Persistence\UserCurrentEquip\UserCurrentEquipDBRepository;

class CreateUserCurrentEquipService
{
    private UserCurrentEquipDBRepository $userCurrentEquipDBRepository;

    public function __construct(UserCurrentEquipDBRepository $userCurrentEquipDBRepository) {
        $this->userCurrentEquipDBRepository = $userCurrentEquipDBRepository;
    }

    public function createUserCurrentEquip($userId) {
        try {
            $this->userCurrentEquipDBRepository->insert($userId);
        } catch(UrukException $e) {
            throw $e;
        }
    }
}