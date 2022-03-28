<?php

namespace App\Service\Equip;

use App\Infrastructure\Persistence\Equip\EquipDBException;
use App\Infrastructure\Persistence\Equip\EquipDBRepository;
use App\Infrastructure\Persistence\Equip\EquipNotExistsException;

class GetEquipService
{
    private EquipDBRepository $equipDBRepository;

    public function __construct(EquipDBRepository $equipDBRepository) {
        $this->equipDBRepository = $equipDBRepository;
    }

    public function getPreparation($equipId) {
        try {
            return $this->equipDBRepository->findByEquipId($equipId);
        } catch (EquipNotExistsException|EquipDBException $e) {
            throw $e;
        }
    }

    public function getRodName($preparationId) {
        try {
            return $this->equipDBRepository->findRodNameByPreparationId($preparationId);
        } catch (EquipDBException $e) {
            throw $e;
        }
    }

    public function getLineName($preparationId) {
        try {
            return $this->equipDBRepository->findLineNameByPreparationId($preparationId);
        } catch (EquipDBException $e) {
            throw $e;
        }
    }

    public function getReelName($preparationId) {
        try {
            return $this->equipDBRepository->findReelNameByPreparationId($preparationId);
        } catch (EquipDBException $e) {
            throw $e;
        }
    }

    public function getHookName($preparationId) {
        try {
            return $this->equipDBRepository->findHookNameByPreparationId($preparationId);
        } catch (EquipDBException $e) {
            throw $e;
        }
    }

    public function getBaitName($preparationId) {
        try {
            return $this->equipDBRepository->findBaitNameByPreparationId($preparationId);
        } catch (EquipDBException $e) {
            throw $e;
        }
    }

    public function getSinkerName($preparationId) {
        try {
            return $this->equipDBRepository->findSinkerNameByPreparationId($preparationId);
        } catch (EquipDBException $e) {
            throw $e;
        }
    }

    public function getRod($rodInfo) {
        try {
            return $this->equipDBRepository->findRodByPreparationId($rodInfo);
        } catch (EquipDBException|EquipNotExistsException $e) {
            throw $e;
        }
    }

    public function getLine($lineInfo) {
        try {
            return $this->equipDBRepository->findLineByPreparationId($lineInfo);
        } catch (EquipDBException|EquipNotExistsException $e) {
            throw $e;
        }
    }

    public function getReel($reelInfo) {
        try {
            return $this->equipDBRepository->findReelByPreparationId($reelInfo);
        } catch (EquipDBException|EquipNotExistsException $e) {
            throw $e;
        }
    }

    public function getHook($hookInfo) {
        try {
            return $this->equipDBRepository->findHookByPreparationId($hookInfo);
        } catch (EquipDBException|EquipNotExistsException $e) {
            throw $e;
        }
    }

    public function getBait($baitInfo) {
        try {
            return $this->equipDBRepository->findBaitByPreparationId($baitInfo);
        } catch (EquipDBException|EquipNotExistsException $e) {
            throw $e;
        }
    }

    public function getSinker($sinkerInfo) {
        try {
            return $this->equipDBRepository->findSinkerByPreparationId($sinkerInfo);
        } catch (EquipDBException|EquipNotExistsException $e) {
            throw $e;
        }
    }
}