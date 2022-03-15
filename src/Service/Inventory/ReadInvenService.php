<?php

namespace App\Service\Inventory;

use App\Infrastructure\Persistence\Inventory\InvenDBRepository;

class ReadInvenService
{
    private InvenDBRepository $invenDBRepository;

    public function __construct(InvenDBRepository $invenDBRepository) {
        $this->invenDBRepository = $invenDBRepository;
    }

    public function getInvenInfo($userId) {
        $inventoryList = $this->invenDBRepository->findInventoryByUserId($userId);

        if (count($inventoryList) == 0) return false;
        return $inventoryList;
    }
}