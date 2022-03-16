<?php

namespace App\Service\Map;

use App\Infrastructure\Persistence\Map\MapDBRepository;

class GetMapService
{
    private MapDBRepository $mapDBRepository;

    public function __construct(MapDBRepository $mapDBRepository) {
        $this->mapDBRepository = $mapDBRepository;
    }

    public function getMapLevelLimit($mapId) {
        // 해당 맵이 없을 수도 있음
        return $this->mapDBRepository->findLevelLimitByMapId($mapId);
    }
}