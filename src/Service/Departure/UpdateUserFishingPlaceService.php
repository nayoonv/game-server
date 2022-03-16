<?php

namespace App\Service\Departure;

use App\Domain\Departure\DepartureInfo;
use App\Infrastructure\Persistence\Map\UserMapDBRepository;
use App\Service\User\GetUserService;
use App\Service\Map\GetMapService;

class UpdateUserFishingPlaceService
{
    private UserMapDBRepository $userMapDBRepository;
    private GetUserService $getUserService;
    private GetMapService $getMapService;

    public function __construct(UserMapDBRepository $userMapDBRepository, GetUserService $getUserService
        , GetMapService $getMapService) {
        $this->userMapDBRepository = $userMapDBRepository;
        $this->getUserService = $getUserService;
        $this->getMapService = $getMapService;
    }

    /**
     * @throws UserLevelLimitException
     */
    public function updateUserMap($userId, $mapId): DepartureInfo {
        // 레벨 제한 거는 부분이 필요하다.
        if ($this->isAvailableToAccessMap($userId, $mapId)) {
            $this->userMapDBRepository->updateUserMap($userId, $mapId);
        }
        else {
            throw new UserLevelLimitException();
        }

        return $this->readDepartureInfo($userId, $mapId);
    }

    public function readDepartureInfo($userId, $mapId) {
        $result = $this->userMapDBRepository->findDepartureInfoByUserId($userId, $mapId);

        // 없는 경우
        if (!$result) {
            $this->userMapDBRepository->createUserMap($userId);
            $result = $this->userMapDBRepository->findDepartureInfoByUserId($userId, $mapId);
        }

        return $result;
    }

    public function isAvailableToAccessMap($userId, $mapId): bool {
        $userLevel =  (int) $this->getUserService->getUserLevel($userId);
        $levelLimit = (int) $this->getMapService->getMapLevelLimit($mapId);
        if ($userLevel >= $levelLimit)
            return true;
        return false;
    }
}