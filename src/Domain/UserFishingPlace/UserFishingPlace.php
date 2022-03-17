<?php

namespace App\Domain\UserFishingPlace;

class UserFishingPlace
{
    private int $mapId;

    private int $maxDepth;

    public function __construct($mapId, $maxDepth) {
        $this->mapId = $mapId;
        $this->maxDepth = $maxDepth;
    }
    public function getMapId() {
        return $this->mapId;
    }
    public function getMaxDepth() {
        return $this->maxDepth;
    }
    public function jsonSerialize(): array {
        return [
            "map_id" => $this->mapId,
            "max_depth" => $this->maxDepth
        ];
    }
}