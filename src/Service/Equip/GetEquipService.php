<?php

namespace App\Service\Equip;

use App\Infrastructure\Persistence\Equip\EquipDBRepository;

class GetEquipService
{
    private EquipDBRepository $equipDBRepository;

    public function __construct(EquipDBRepository $equipDBRepository) {
        $this->equipDBRepository = $equipDBRepository;
    }

    public function getPreparation($equipId) {
        return $this->equipDBRepository->findByEquipId($equipId);
    }

    public function getRodName($preparationId) {
        return $this->equipDBRepository->findRodNameByPreparationId($preparationId);
    }

    public function getLineName($preparationId) {
        return $this->equipDBRepository->findLineNameByPreparationId($preparationId);
    }

    public function getReelName($preparationId) {
        return $this->equipDBRepository->findReelNameByPreparationId($preparationId);
    }

    public function getHookName($preparationId) {
        return $this->equipDBRepository->findHookNameByPreparationId($preparationId);
    }

    public function getBaitName($preparationId) {
        return $this->equipDBRepository->findBaitNameByPreparationId($preparationId);
    }

    public function getSinkerName($preparationId) {
        return $this->equipDBRepository->findSinkerNameByPreparationId($preparationId);
    }

    public function getRod($rodInfo) {
        return $this->equipDBRepository->findRodByPreparationId($rodInfo);
    }

    public function getLine($lineInfo) {
        return $this->equipDBRepository->findLineByPreparationId($lineInfo);
    }

    public function getReel($reelInfo) {
        return $this->equipDBRepository->findReelByPreparationId($reelInfo);
    }

    public function getHook($hookInfo) {
        return $this->equipDBRepository->findHookByPreparationId($hookInfo);
    }

    public function getBait($baitInfo) {
        return $this->equipDBRepository->findBaitByPreparationId($baitInfo);
    }

    public function getSinker($sinkerInfo) {
        return $this->equipDBRepository->findSinkerByPreparationId($sinkerInfo);
    }
}