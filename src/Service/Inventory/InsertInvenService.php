<?php

namespace App\Service\Inventory;

use App\Infrastructure\Persistence\Inventory\InvenDBRepository;

class InsertInvenService
{
    private InvenDBRepository $invenDBRepository;

    public function __construct(InvenDBRepository $invenDBRepository) {
        $this->invenDBRepository = $invenDBRepository;
    }

    public function insertInvenFish($userFishId, $userId, $datetime) {
        $this->invenDBRepository->insertUserFish($userFishId, $userId, $datetime);
    }
}