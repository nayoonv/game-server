<?php

namespace App\Service\UserCurrentEquip;

use App\Domain\UserCurrentEquip\UserCurrentEquipDetail;
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
        , GetUserEquipService $getUserEquipService, GetEquipService $getEquipService) {
        $this->userCurrentEquipDBRepository = $userCurrentEquipDBRepository;
        $this->getUserEquipService = $getUserEquipService;
        $this->getEquipService = $getEquipService;
    }

    public function getUserCurrentEquipInfo($userId) {
        // 간단하게 id만 불러온 상황
        $currentEquipInfo = $this->userCurrentEquipDBRepository->findByUserId($userId);

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
    }

    public function getPreparationFromEquip($equipId) {
        return $this->getEquipService->getPreparation($equipId);
    }
    public function getUserRodInfo($userEquipId) {
        $userRodInfo = $this->getUserEquipService->getUpgradeAvailableEquipByUserEquipId($userEquipId);

        $preparationInfo = $this->getPreparationFromEquip($userRodInfo->getEquipId());
        $userRodInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

        return $this->getEquipService->getRod($userRodInfo);
    }

    public function getUserLineInfo($userEquipId) {
        $userLineInfo = $this->getUserEquipService->getUpgradeAvailableEquipByUserEquipId($userEquipId);

        $preparationInfo = $this->getPreparationFromEquip($userLineInfo->getEquipId());
        $userLineInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

        return $this->getEquipService->getLine($userLineInfo);
    }

    public function getUserReelInfo($userEquipId) {
        $userReelInfo = $this->getUserEquipService->getUpgradeAvailableEquipByUserEquipId($userEquipId);

        $preparationInfo = $this->getPreparationFromEquip($userReelInfo->getEquipId());
        $userReelInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

        return $this->getEquipService->getReel($userReelInfo);
    }

    public function getUserHookInfo($userEquipId) {
        $userHookInfo = $this->getUserEquipService->getUpgradeUnavailableEquipByUserEquipId($userEquipId);

        $preparationInfo = $this->getPreparationFromEquip($userHookInfo->getEquipId());
        $userHookInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

        return $this->getEquipService->getHook($userHookInfo);
    }

    public function getUserBaitInfo($userEquipId) {
        $userBaitInfo = $this->getUserEquipService->getUpgradeUnavailableEquipByUserEquipId($userEquipId);

        $preparationInfo = $this->getPreparationFromEquip($userBaitInfo->getEquipId());
        $userBaitInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

        return $this->getEquipService->getBait($userBaitInfo);
    }

    public function getUserSinkerInfo($userEquipId) {
        $userSinkerInfo = $this->getUserEquipService->getUpgradeUnavailableEquipByUserEquipId($userEquipId);

        $preparationInfo = $this->getPreparationFromEquip($userSinkerInfo->getEquipId());
        $userSinkerInfo->setPreparation($preparationInfo->getPreparationId(), $preparationInfo->getPreparationTypeId());

        return $this->getEquipService->getSinker($userSinkerInfo);
    }

}