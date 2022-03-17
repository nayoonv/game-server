<?php

namespace App\Domain\Equip;

class UserEquipUpgradeAvailable
{
    private int $equipId;

    private int $preparationId;

    private int $preparationTypeId;

    private int $level;

    private int $durability;

    public function __construct($equipId, $level, $durability) {
        $this->equipId = $equipId;
        $this->level = $level;
        $this->durability = $durability;
    }

    public function getEquipId() {
        return $this->equipId;
    }
    public function getLevel() {
        return $this->level;
    }
    public function getDurability() {
        return $this->durability;
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