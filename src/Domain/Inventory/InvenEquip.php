<?php

namespace App\Domain\Inventory;

class InvenEquip
{
    private int $inventoryId;

    private int $inventoryTypeId;

    private int $userEquipId;

    private string $userEquipName;

    public function __construct($inventoryId, $inventoryTypeId, $userEquipId, $userEquipName) {
        $this->inventoryId = $inventoryId;
        $this->inventoryTypeId = $inventoryTypeId;
        $this->userEquipId = $userEquipId;
        $this->userEquipName = $userEquipName;
    }

    public function jsonSerialize(): array
    {
        // TODO: Implement jsonSerialize() method.
        return [
            'inventory_id' => $this->inventoryId,
            'inventory_type_id' => $this->inventoryTypeId,
            'user_fish_id' => $this->userEquipId,
            'user_fish-name' => $this->userEquipName
        ];
    }
}