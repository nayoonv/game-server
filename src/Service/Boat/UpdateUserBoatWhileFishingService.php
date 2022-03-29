<?php

namespace App\Service\Boat;

use App\Exception\Base\UrukException;
use App\Exception\Departure\NeedBoatDurabilityException;
use App\Exception\Fish\NotFishingStatusException;
use App\Infrastructure\Persistence\Boat\UserBoatDBRepository;
use App\Service\Map\GetMapService;

class UpdateUserBoatWhileFishingService
{
    private UserBoatDBRepository $userBoatDBRepository;
    private GetMapService $getMapService;
    private GetUserBoatService $getUserBoatService;

    public function __construct(UserBoatDBRepository $userBoatDBRepository, GetMapService $getMapService
        , GetUserBoatService                         $getUserBoatService)
    {
        $this->userBoatDBRepository = $userBoatDBRepository;
        $this->getMapService = $getMapService;
        $this->getUserBoatService = $getUserBoatService;
    }

    public function updateUserBoatDurability($userId)
    {
        try {
            // 현재 배가 있는 위치 정보
            $userFishingPlaceInfo = $this->getMapService->getUserFishingPlace($userId);

            // 현재 낚시 중인지 체크
            if ($this->isFishing()) {
                // 현재 배의 정보와 위치에 대한 상세 정보
                $userBoatInfo = $this->getUserBoatService->getUserBoat($userId);
                $mapInfo = $this->getMapService->getMap($userFishingPlaceInfo->getMapId());

                // 내구도 상태 확인
                if ($this->isAvailableDurability($userBoatInfo, $mapInfo)) {
                    // 낚시 도중 내구도 감소 업데이트
                    $reducedDurability = $userBoatInfo->getUserBoatDurability() - $mapInfo->getReducedDurability();
                    $this->userBoatDBRepository->updateUserBoatDurability($userId, $mapInfo->getMapId(), $reducedDurability);

                    return $reducedDurability;
                }
            }
        } catch (UrukException $e) {
            return $e->response();
        }
    }

    public function isAvailableDurability($userBoatInfo, $mapInfo): bool
    {
        $boatDurability = $userBoatInfo->getUserBoatDurability();
        $mapDurability = $mapInfo->getReducedDurability();
        if ($boatDurability - $mapDurability < 0) {
            throw new NeedBoatDurabilityException();
        }
        return true;
    }

    public function isFishing($userFishingPlace): bool
    {
        $fishing = $userFishingPlace->getFishing();

        if ($fishing == 1) return true;
        else {
            throw new NotFishingStatusException();
        }
    }
}