<?php

namespace App\Domain\Equip;

class UserEquip
{
    private int $userEquipId;

    private int $userId;

    private int $equipId;

    private int $upgradeAvailable;

    public function __construct($userEquipId, $userId, $equipId, $upgradeAvailable) {
        $this->userEquipId = $userEquipId;
        $this->userId = $userId;
        $this->equipId = $equipId;
        $this->upgradeAvailable = $upgradeAvailable;
    }

    public function getUserEquipId() {
        return $this->userEquipId;
    }
    public function getEquipId() {
        return $this->equipId;
    }

    public function getUpgradeAvailable() {
        return $this->upgradeAvailable;
    }

}