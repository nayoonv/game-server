<?php

namespace App\Domain\Inventory;
use JsonSerializable;

class InvenEquip implements JsonSerializable
{
    private int $inventoryId;

    private int $inventoryTypeId;

    private int $equipId;

    private string $equipName;

    public function __construct($inventoryId, $inventoryTypeId, $equipId) {
        $this->inventoryId = $inventoryId;
        $this->inventoryTypeId = $inventoryTypeId;
        $this->equipId = $equipId;
    }

    public function getInventoryTypeId() {
        return $this->inventoryTypeId;
    }

    public function getEquipId() {
        return $this->equipId;
    }

    public function setEquipName($equipName) {
        $this->equipName = $equipName;
    }

    public function jsonSerialize(): array
    {
        // TODO: Implement jsonSerialize() method.
        return [
            'inventory_id' => $this->inventoryId,
            'inventory_type_id' => $this->inventoryTypeId,
            'user_equip_id' => $this->equipId,
            'user_equip_name' => $this->equipName
        ];
    }
}