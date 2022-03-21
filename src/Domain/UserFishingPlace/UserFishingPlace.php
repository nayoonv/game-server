<?php

namespace App\Domain\UserFishingPlace;

class UserFishingPlace
{
    private int $mapId;

    private int $maxDepth;

    private int $fishing;

    public function __construct($mapId, $maxDepth, $fishing) {
        $this->mapId = $mapId;
        $this->maxDepth = $maxDepth;
        $this->fishing = $fishing;
    }
    public function getMapId() {
        return $this->mapId;
    }
    public function getMaxDepth() {
        return $this->maxDepth;
    }
    public function getFishing() {
        return $this->fishing;
    }
    public function jsonSerialize(): array {
        return [
            "map_id" => $this->mapId,
            "max_depth" => $this->maxDepth
        ];
    }
}