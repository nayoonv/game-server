<?php

namespace App\Domain\Departure;

class DepartureInfo
{
    private int $mapId;

    private string $mapName;

    private string $accessTime;

    private int $distance;

    private int $costToSail;

    private int $timeToSail;

    private int $reducedDurability;

    private int $userFatigue;

    private int $userBoatDurability;

    private int $userBoatFuel;

    public function __construct($mapId, $mapName, $accessTime, $distance, $costToSail, $timeToSail
        , $reducedDurability, $userFatigue, $userBoatDurability, $userBoatFuel) {
        $this->mapId = $mapId;
        $this->mapName = $mapName;
        $this->accessTime = $accessTime;
        $this->distance = $distance;
        $this->costToSail = $costToSail;
        $this->timeToSail = $timeToSail;
        $this->reducedDurability = $reducedDurability;
        $this->userFatigue = $userFatigue;
        $this->userBoatDurability = $userBoatDurability;
        $this->userBoatFuel = $userBoatFuel;
    }

    public function jsonSerialize(): array {
        return [
            'map_id' => $this->mapId,
            'map_name' => $this->mapName,
            'access_time' => $this->accessTime,
            'distance' => $this->distance,
            'cost_to_sail' => $this->costToSail,
            'time_to_sail' => $this->timeToSail,
            'reduced_durability' => $this->reducedDurability,
            'user_fatigue' => $this->userFatigue,
            'user_boat_durability' => $this->userBoatDurability,
            'user_boat_fuel' => $this->userBoatFuel
        ];
    }
}