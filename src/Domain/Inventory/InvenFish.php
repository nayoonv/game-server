<?php

namespace App\Domain\Inventory;

class InvenFish
{
    private int $inventoryId;

    private int $inventoryTypeId;

    private int $userFishId;

    private string $userFishName;

    public function __construct($inventoryId, $inventoryTypeId, $userFishId, $userFishName) {
        $this->inventoryId = $inventoryId;
        $this->inventoryTypeId = $inventoryTypeId;
        $this->userFishId = $userFishId;
        $this->userFishName = $userFishName;
    }

    public function jsonSerialize(): array
    {
        // TODO: Implement jsonSerialize() method.
        return [
            'inventory_id' => $this->inventoryId,
            'inventory_type_id' => $this->inventoryTypeId,
            'user_fish_id' => $this->userFishId,
            'user_fish_name' => $this->userFishName
        ];
    }
}
