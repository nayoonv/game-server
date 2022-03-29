<?php

namespace App\Service\UserEquip;

use App\Exception\Base\UrukException;
use App\Exception\Equip\UserEquipDBException;
use App\Infrastructure\Persistence\Equip\UserEquipDBRepository;

class GetUserEquipService
{
    private UserEquipDBRepository $userEquipDBRepository;

    public function __construct(UserEquipDBRepository $userEquipDBRepository)
    {
        $this->userEquipDBRepository = $userEquipDBRepository;
    }

    public function getUserEquip($userEquipId) {
        try {
            return $this->userEquipDBRepository->findEquipByUserEquipId($userEquipId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUpgradeAvailableEquipByUserEquipId($userEquipId)
    {
        try {
            return $this->userEquipDBRepository->findUpgradeAvailableEquipByUserEquipId($userEquipId);
        } catch (UrukException $exception) {
            throw $exception;
        }
    }

    public function getUpgradeUnavailableEquipByUserEquipId($userEquipId)
    {
        try {
            return $this->userEquipDBRepository->findUpgradeUnavailableEquipByUserEquipId($userEquipId);
        } catch (UrukException $exception) {
            throw $exception;
        }
    }
}