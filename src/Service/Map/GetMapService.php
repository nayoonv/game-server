<?php

namespace App\Service\Map;

use App\Exception\Base\UrukException;
use App\Infrastructure\Persistence\Map\MapDBRepository;
use App\Infrastructure\Persistence\Map\UserMapDBRepository;

class GetMapService
{
    private MapDBRepository $mapDBRepository;
    private UserMapDBRepository $userMapDBRepository;

    public function __construct(MapDBRepository $mapDBRepository, UserMapDBRepository $userMapDBRepository)
    {
        $this->mapDBRepository = $mapDBRepository;
        $this->userMapDBRepository = $userMapDBRepository;
    }

    public function getMap($mapId)
    {
        try {
            // 해당 맵이 없을 수도 있음
            return $this->mapDBRepository->findByMapId($mapId);
        } catch (UrukException $e) {
            throw $e;
        }
    }

    public function getUserFishingPlace($userId)
    {
        try {
            return $this->userMapDBRepository->findUserFishingPlaceByUserId($userId);
        } catch (UrukException $e) {
            throw $e;
        }
    }
}