<?php

namespace App\Service\UserCurrentEquip;

use App\Domain\UserCurrentEquip\UserCurrentEquipDetail;
use App\Exception\Base\UrukException;
use App\Exception\Book\EquipNotExistsException;
use App\Exception\Equip\EquipDBException;
use App\Exception\Equip\UserCurrentEquipDBException;
use App\Exception\Equip\UserCurrentEquipNotExistsException;
use App\Infrastructure\Persistence\UserCurrentEquip\UserCurrentEquipDBRepository;
use App\Service\Equip\GetEquipService;
use App\Service\UserEquip\GetUserEquipService;
use App\Util\SuccessResponseManager;

class GetUserCurrentEquipService
{
    private UserCurrentEquipDBRepository $userCurrentEquipDBRepository;
    private GetUserEquipService $getUserEquipService;
    private GetEquipService $getEquipService;

    public function __construct(UserCurrentEquipDBRepository $userCurrentEquipDBRepository
        , GetUserEquipService                                $getUserEquipService, GetEquipService $getEquipService)
    {
        $this->userCurrentEquipDBRepository = $userCurrentEquipDBRepository;
        $this->getUserEquipService = $getUserEquipService;
        $this->getEquipService = $getEquipService;
    }

    public function getUserCurrentEquip($userId)
    {
        try {
            return SuccessResponseManager::response($this->getUserCurrentEquipInfo($userId));
        } catch (UrukException $e) {
            return $e->response();
        }
    }

    public function getByUserId($userId)
    {
        try {
            return $this->userCurrentEquipDBRepository->findByUserId($userId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUserCurrentEquipInfo($userId)
    {
        try {
            // 간단하게 id만 불러온 상황
            $currentEquipInfo = $this->getByUserId($userId);

            // 낚싯대
            $rod = $this->getUserRodInfo($currentEquipInfo->getUserRodId());

            // 낚싯줄
            $line = $this->getUserLineInfo($currentEquipInfo->getUserLineId());

            // 릴
            $reel = $this->getUserReelInfo($currentEquipInfo->getUserReelId());

            // 미끼
            $bait = $this->getUserBaitInfo($currentEquipInfo->getUserBaitId());

            // 바늘
            $hook = $this->getUserHookInfo($currentEquipInfo->getUserHookId());

            // 추추
            $sinker = $this->getUserSinkerInfo($currentEquipInfo->getUserSinkerId());

            return new UserCurrentEquipDetail($rod, $line, $reel, $hook, $bait, $sinker);

        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getPreparationFromEquip($equipId)
    {
        try {
            return $this->getEquipService->getPreparation($equipId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUserRodInfo($userEquipId)
    {
        try {
            $userRodInfo = $this->getUserEquipService->getUpgradeAvailableEquipByUserEquipId($userEquipId);

            $preparationInfo = $this->getPreparationFromEquip($userRodInfo->getEquipId());
            $userRodInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

            return $this->getEquipService->getRod($userRodInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUserLineInfo($userEquipId)
    {
        try {
            $userLineInfo = $this->getUserEquipService->getUpgradeAvailableEquipByUserEquipId($userEquipId);

            $preparationInfo = $this->getPreparationFromEquip($userLineInfo->getEquipId());
            $userLineInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

            return $this->getEquipService->getLine($userLineInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUserReelInfo($userEquipId)
    {
        try {
            $userReelInfo = $this->getUserEquipService->getUpgradeAvailableEquipByUserEquipId($userEquipId);

            $preparationInfo = $this->getPreparationFromEquip($userReelInfo->getEquipId());
            $userReelInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

            return $this->getEquipService->getReel($userReelInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUserHookInfo($userEquipId)
    {
        try {
            $userHookInfo = $this->getUserEquipService->getUpgradeUnavailableEquipByUserEquipId($userEquipId);

            $preparationInfo = $this->getPreparationFromEquip($userHookInfo->getEquipId());
            $userHookInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

            return $this->getEquipService->getHook($userHookInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUserBaitInfo($userEquipId)
    {
        try {
            $userBaitInfo = $this->getUserEquipService->getUpgradeUnavailableEquipByUserEquipId($userEquipId);

            $preparationInfo = $this->getPreparationFromEquip($userBaitInfo->getEquipId());
            $userBaitInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

            return $this->getEquipService->getBait($userBaitInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUserSinkerInfo($userEquipId)
    {
        try {
            $userSinkerInfo = $this->getUserEquipService->getUpgradeUnavailableEquipByUserEquipId($userEquipId);

            $preparationInfo = $this->getPreparationFromEquip($userSinkerInfo->getEquipId());
            $userSinkerInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

            return $this->getEquipService->getSinker($userSinkerInfo);
        } catch (UrukException $e) {
            throw $e;
        }
    }

}