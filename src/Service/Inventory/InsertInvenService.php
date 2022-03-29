<?php

namespace App\Service\Inventory;

use App\Exception\Base\UrukException;
use App\Infrastructure\Persistence\Inventory\InvenDBRepository;

class InsertInvenService
{
    private InvenDBRepository $invenDBRepository;

    public function __construct(InvenDBRepository $invenDBRepository) {
        $this->invenDBRepository = $invenDBRepository;
    }

    public function insertInvenFish($userFishId, $userId, $datetime) {
        try {
            $this->invenDBRepository->insertUserFish($userFishId, $userId, $datetime);
        } catch (UrukException $e) {
            throw $e;
        }
    }
    public function insertInvenEquip($userEquipId, $userId) {
        try {
            return $this->invenDBRepository->insertUserEquip($userEquipId, $userId);
        } catch (UrukException $e) {
            throw $e;
        }
    }
}