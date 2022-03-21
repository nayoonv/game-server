<?php

namespace App\Service\Boat;

use App\Infrastructure\Persistence\Boat\UserBoatDBRepository;
use App\Service\Departure\NeedBoatDurabilityException;
use App\Service\Fishing\NotFishingStatusException;
use App\Service\Map\GetMapService;

class UpdateUserBoatWhileFishingService
{
    private UserBoatDBRepository $userBoatDBRepository;
    private GetMapService $getMapService;
    private GetUserBoatService $getUserBoatService;

    public function __construct(UserBoatDBRepository $userBoatDBRepository, GetMapService $getMapService
        , GetUserBoatService $getUserBoatService) {
        $this->userBoatDBRepository = $userBoatDBRepository;
        $this->getMapService = $getMapService;
        $this->getUserBoatService = $getUserBoatService;
    }

    public function updateUserBoatDurability($userId) {
        // 현재 배가 있는 위치 정보
        $userFishingPlaceInfo = $this->getMapService->getUserFishingPlace($userId);
        try {
            // 현재 낚시 중인지 체크
            if ($this->isFishing()) {
                // 현재 배의 정보와 위치에 대한 상세 정보
                $userBoatInfo = $this->getUserBoatService->getUserBoat($userId);
                $mapInfo = $this->getMapService->getMap($userFishingPlaceInfo->getMapId());
                try {
                    // 내구도가 감소되었을 때 0보다 아래로 내려갈 경우 입항할 수 있도록 함
                    if ($this->isAvailableDurability($userBoatInfo, $mapInfo)) {
                        $reducedDurability = $userBoatInfo->getUserBoatDurability() - $mapInfo->getReducedDurability();
                        $this->userBoatDBRepository->updateUserBoatDurability($userId, $mapInfo->getMapId(), $reducedDurability);
                        return $reducedDurability;
                    }
                } catch(NeedBoatDurabilityException $needBoatDurabilityException) {
                    return $needBoatDurabilityException->exceptionResult();
                }
            }
        } catch(NotFishingStatusException $notFishingStatusException) {
            return $notFishingStatusException->exceptionResult("출항");
        }
    }

    public function isAvailableDurability($userBoatInfo, $mapInfo): bool {
        $boatDurability = $userBoatInfo->getUserBoatDurability();
        $mapDurability = $mapInfo->getReducedDurability();
        if ($boatDurability - $mapDurability < 0) {
            throw new NeedBoatDurabilityException();
        }
        return true;
    }

    public function isFishing($userFishingPlace): bool {
        $fishing = $userFishingPlace->getFishing();

        if ($fishing == 1) return true;
        else{
            throw new NotFishingStatusException();
        }
    }
}