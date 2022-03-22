<?php

namespace App\Service\Inventory;

use App\Infrastructure\Persistence\Inventory\InvenDBRepository;
use App\Infrastructure\Persistence\Inventory\InvenInsertFishException;

class InsertInvenService
{
    private InvenDBRepository $invenDBRepository;

    public function __construct(InvenDBRepository $invenDBRepository) {
        $this->invenDBRepository = $invenDBRepository;
    }

    public function insertInvenFish($userFishId, $userId, $datetime) {
        try {
            $this->invenDBRepository->insertUserFish($userFishId, $userId, $datetime);
        } catch (InvenInsertFishException $e) {
            throw $e;
        }
    }
}