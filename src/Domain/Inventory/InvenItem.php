<?php

namespace App\Domain\Inventory;

class InvenItem
{
    private int $inventoryId;

    private int $userId;

    private int $itemId;

    private string $getDate;

    private int $inventoryTypeId;

    public function __construct($inventoryId, $userId, $itemId, $getDate, $inventoryTypeId) {
        $this->inventoryId = $inventoryId;
        $this->userId = $userId;
        $this->itemId = $itemId;
        $this->getDate = $getDate;
        $this->inventoryTypeId = $inventoryTypeId;
    }

    public function getItemId() {
        return $this->itemId;
    }

    public function getInventoryTypeId() {
        return $this->inventoryTypeId;
    }

}