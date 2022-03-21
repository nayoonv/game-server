<?php

namespace App\Domain\Map;

class Map
{
    private int $mapId;

    private string $mapName;

    private int $distance;

    private int $costToSail;

    private int $timeToSail;

    private int $levelLimit;

    private int $reducedDurability;

    public function __construct($mapId, $mapName, $distance, $costToSail, $timeToSail, $levelLimit
        , $reducedDurability) {
        $this->mapId = $mapId;
        $this->mapName = $mapName;
        $this->distance = $distance;
        $this->costToSail = $costToSail;
        $this->timeToSail = $timeToSail;
        $this->levelLimit = $levelLimit;
        $this->reducedDurability = $reducedDurability;
    }
    public function getMapId() {
        return $this->mapId;
    }
    public function getCostToSail() {
        return $this->costToSail;
    }
    public function getTimeToSail() {
        return $this->timeToSail;
    }
    public function getLevelLimit() {
        return $this->levelLimit;
    }
    public function getReducedDurability() {
        return $this->reducedDurability;
    }

    public function jsonSerialize(): array {
        return [
            'map_id' => $this->mapId,
            'map_name' => $this->mapName,
            'distance' => $this->distance,
            'cost_to_sail' => $this->costToSail,
            'time_to_sail' => $this->timeToSail,
            'level_limit' => $this->levelLimit,
            'reduced_durability' => $this->reducedDurability
        ];
    }
}