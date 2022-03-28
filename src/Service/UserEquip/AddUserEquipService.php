<?php

namespace App\Service\UserEquip;

use App\Infrastructure\Persistence\Equip\EquipDBException;
use App\Infrastructure\Persistence\Equip\EquipNotExistsException;
use App\Infrastructure\Persistence\Equip\UserEquipDBException;
use App\Infrastructure\Persistence\Equip\UserEquipDBRepository;
use App\Service\Equip\GetEquipService;

class AddUserEquipService
{
    private UserEquipDBRepository $userEquipDBRepository;
    private GetEquipService $getEquipService;

    public function __construct(UserEquipDBRepository $userEquipDBRepository, GetEquipService $getEquipService) {
        $this->userEquipDBRepository = $userEquipDBRepository;
        $this->getEquipService = $getEquipService;
    }

    public function addEquipUpgradeAvailable($userId, $equipId, $level, $equipType) {
        try {
            $preparationId = $this->getEquipService->getPreparation($equipId)->getPreparationId();
            switch($equipType) {
                case 1:
                    return $this->userEquipDBRepository->insertRod($userId, $equipId, $level, $preparationId);
                case 2:
                    return $this->userEquipDBRepository->insertLine($userId, $equipId, $level, $preparationId);
                case 3:
                    return $this->userEquipDBRepository->insertReel($userId, $equipId, $level, $preparationId);
            }
        } catch(EquipNotExistsException|EquipDBException|UserEquipDBException $e) {
            throw $e;
        }
    }

    public function addEquipUpgradeUnavailable($userId, $equipId) {
        try {
            return $this->userEquipDBRepository->insertEquipUpgradeUnavailable($userId, $equipId);
        } catch (UserEquipDBException $e) {
            throw $e;
        }
    }
}