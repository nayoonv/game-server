<?php

namespace App\Service\Equip;

use App\Exception\Base\UrukException;
use App\Exception\Book\EquipNotExistsException;
use App\Exception\Equip\EquipDBException;
use App\Infrastructure\Persistence\Equip\EquipDBRepository;

class GetEquipService
{
    private EquipDBRepository $equipDBRepository;

    public function __construct(EquipDBRepository $equipDBRepository) {
        $this->equipDBRepository = $equipDBRepository;
    }

    public function getPreparation($equipId) {
        try {
            return $this->equipDBRepository->findByEquipId($equipId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getRodName($preparationId) {
        try {
            return $this->equipDBRepository->findRodNameByPreparationId($preparationId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getLineName($preparationId) {
        try {
            return $this->equipDBRepository->findLineNameByPreparationId($preparationId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getReelName($preparationId) {
        try {
            return $this->equipDBRepository->findReelNameByPreparationId($preparationId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getHookName($preparationId) {
        try {
            return $this->equipDBRepository->findHookNameByPreparationId($preparationId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getBaitName($preparationId) {
        try {
            return $this->equipDBRepository->findBaitNameByPreparationId($preparationId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getSinkerName($preparationId) {
        try {
            return $this->equipDBRepository->findSinkerNameByPreparationId($preparationId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getRod($rodInfo) {
        try {
            return $this->equipDBRepository->findRodByPreparationId($rodInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getLine($lineInfo) {
        try {
            return $this->equipDBRepository->findLineByPreparationId($lineInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getReel($reelInfo) {
        try {
            return $this->equipDBRepository->findReelByPreparationId($reelInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getHook($hookInfo) {
        try {
            return $this->equipDBRepository->findHookByPreparationId($hookInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getBait($baitInfo) {
        try {
            return $this->equipDBRepository->findBaitByPreparationId($baitInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getSinker($sinkerInfo) {
        try {
            return $this->equipDBRepository->findSinkerByPreparationId($sinkerInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }
}