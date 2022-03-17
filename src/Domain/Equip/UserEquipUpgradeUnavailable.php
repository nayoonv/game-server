<?php

namespace App\Domain\Equip;

class UserEquipUpgradeUnavailable
{
    private int $equipId;

    private int $preparationId;

    private int $preparationTypeId;

    public function __construct($equipId) {
        $this->equipId = $equipId;
    }

    public function getEquipId() {
        return $this->equipId;
    }

    public function getPreparationId() {
        return $this->preparationId;
    }
    public function setPreparationId($preparationId) {
        $this->preparationId = $preparationId;
    }
    public function getPreparationTypeId() {
        return $this->preparationTypeId;
    }
    public function setPreparationTypeId($preparationTypeId) {
        $this->preparationTypeId = $preparationTypeId;
    }
    public function setPreparation($preparationId, $preparationTypeId) {
        $this->setPreparationId($preparationId);
        $this->setPreparationTypeId($preparationTypeId);
    }
}