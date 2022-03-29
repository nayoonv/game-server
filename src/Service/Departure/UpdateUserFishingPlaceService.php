<?php

namespace App\Service\Departure;

use App\Exception\Departure\NeedBoatDurabilityException;
use App\Exception\Departure\NeedBoatFuelException;
use App\Exception\Departure\NeedUserFatigueException;
use App\Exception\Departure\UserLevelLimitException;
use App\Exception\Fish\NotFishingStatusException;
use App\Exception\Login\UserAccountUserDBException;
use App\Exception\Map\UserMapDBException;
use App\Exception\User\UserDBException;
use App\Infrastructure\Persistence\Map\UserMapDBRepository;
use App\Service\Boat\GetUserBoatService;
use App\Service\Map\GetMapService;
use App\Service\User\GetUserService;
use App\Service\UserAccountUser\GetUserAccountUserService;
use App\Util\Log;
use App\Util\SuccessResponseManager;

class UpdateUserFishingPlaceService
{
    private UserMapDBRepository $userMapDBRepository;
    private GetUserService $getUserService;
    private GetUserBoatService $getUserBoatService;
    private GetMapService $getMapService;
    private GetUserAccountUserService $getUserAccountUserService;

    public function __construct(UserMapDBRepository $userMapDBRepository, GetUserService $getUserService
        , GetUserBoatService                        $getUserBoatService, GetMapService $getMapService
        , GetUserAccountUserService                 $getUserAccountUserService)
    {
        $this->userMapDBRepository = $userMapDBRepository;
        $this->getUserService = $getUserService;
        $this->getUserBoatService = $getUserBoatService;
        $this->getMapService = $getMapService;
        $this->getUserAccountUserService = $getUserAccountUserService;
    }

    /**
     * @throws UserLevelLimitException
     */
    public function updateUserMap($userId, $mapId)
    {

        try {
            $userInfo = $this->getUserService->getUser($userId);
            $userBoatInfo = $this->getUserBoatService->getUserBoat($userId);
            $mapInfo = $this->getMapService->getMap($mapId);

            if ($this->isAvailableToDepart($userInfo, $mapInfo, $userBoatInfo)
                && $this->isAvailableToAccessMap($userInfo, $mapInfo)) {
                /*
                 * user_fishing_place에서 사용자가 이동하고자 하는 위치로 이동시키고 낚시 중으로 상태를 변경한다.
                 * fishing = 0 -> 입항, 1 -> 출항
                 */

                $this->userMapDBRepository->updateUserMap($userId, $mapId);

                $result = $this->readDepartureInfo($userId, $mapId);
                $hiveId = $this->getUserAccountUserService->getHiveId($userId);
                Log::write("DEPART"
                    , ['hive_id' => $hiveId, 'user_id' => $userId, 'user_level' => $userInfo->getLevel(), 'map_id' => $mapId]);
                return SuccessResponseManager::response($result);
            }
        } catch (NeedBoatDurabilityException|NeedUserFatigueException|NeedBoatFuelException|UserDBException|UserAccountUserDBException|UserMapDBException $e) {
            return $e->response();
        }
    }

    public function readDepartureInfo($userId, $mapId)
    {
        try {
            $result = $this->userMapDBRepository->findDepartureInfoByUserId($userId, $mapId);

            // 없는 경우
            if (!$result) {
                $this->userMapDBRepository->createUserMap($userId);
                $result = $this->userMapDBRepository->findDepartureInfoByUserId($userId, $mapId);
            }

            return $result;
        } catch (UserMapDBException $e) {
            throw $e;
        }
    }

    // 출항 가능한지 체크
    public function isAvailableToDepart($userInfo, $mapInfo, $userBoatInfo): bool
    {
        $userFatigue = $userInfo->getFatigue();
        $costToSail = $mapInfo->getCostToSail();
        $timeToSail = $mapInfo->getTimeToSail();
        $reducedDurability = $mapInfo->getReducedDurability();
        $boatDurability = $userBoatInfo->getUserBoatDurability();
        $boatFuel = $userBoatInfo->getUserBoatFuel();

        if ($boatDurability - $reducedDurability < 0) {
            throw new NeedBoatDurabilityException();
        }
        if ($userFatigue >= $timeToSail) {
            throw new NeedUserFatigueException();
        }
        if ($boatFuel - $costToSail < 0) {
            throw new NeedBoatFuelException();
        }

        return true;
    }

    // 출항 가능 레벨인지 체크
    public function isAvailableToAccessMap($userInfo, $mapInfo): bool
    {
        $userLevel = (int)$userInfo->getLevel();
        $levelLimit = (int)$mapInfo->getLevelLimit();
        if ($userLevel >= $levelLimit)
            return true;
        throw new UserLevelLimitException();
    }

    public function updateFishingStatus($userId, $fishing)
    {
        try {
            $this->userMapDBRepository->updateFishingStatus($userId, $fishing);
        } catch (UserMapDBException|NotFishingStatusException $e) {
            throw $e;
        }
    }
}