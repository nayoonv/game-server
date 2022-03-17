<?php

namespace App\Service\UserEquip;

use App\Infrastructure\Persistence\Equip\UserEquipDBRepository;

class GetUserEquipService
{
    private UserEquipDBRepository $userEquipDBRepository;

    public function __construct(UserEquipDBRepository $userEquipDBRepository) {
        $this->userEquipDBRepository = $userEquipDBRepository;
    }

    public function getUpgradeAvailableEquipByUserEquipId($userEquipId) {
        return $this->userEquipDBRepository->findUpgradeAvailableEquipByUserEquipId($userEquipId);
    }

    public function getUpgradeUnavailableEquipByUserEquipId($userEquipId) {
        return $this->userEquipDBRepository->findUpgradeUnavailableEquipByUserEquipId($userEquipId);
    }
}