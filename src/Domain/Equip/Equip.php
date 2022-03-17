<?php

namespace App\Domain\Equip;

class Equip
{
    private int $equipId;

    private int $preparationId;

    private int $preparationTypeId;

    public function __construct($equipId, $preparationId, $preparationTypeId) {
        $this->equipId = $equipId;
        $this->preparationId = $preparationId;
        $this->preparationTypeId = $preparationTypeId;
    }

    public function getEquipId() {
        return $this->equipId;
    }

    public function getPreparationId() {
        return $this->preparationId;
    }

    public function getPreparationTypeId() {
        return $this->preparationTypeId;
    }
}