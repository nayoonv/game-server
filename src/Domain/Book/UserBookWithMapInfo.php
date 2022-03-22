<?php

namespace App\Domain\Book;

use JsonSerializable;

class UserBookWithMapInfo implements JsonSerializable
{
    private int $fishId;

    private string $fishName;

    private int $mapId;

    private string $mapName;

    private int $maxLength;

    private int $maxWeight;

    private string $catchDate;

    public function __construct($fishId, $fishName, $mapId, $mapName, $maxLength, $maxWeight) {
        $this->fishId = $fishId;
        $this->fishName = $fishName;
        $this->mapId = $mapId;
        $this->mapName = $mapName;
        $this->maxLength = $maxLength;
        $this->maxWeight = $maxWeight;
    }

    public function getFishId() {
        return $this->fishId;
    }

    public function setCatchDate($catchDate) {
        $this->catchDate = $catchDate;
    }

    public function getCatchDate() {
        return $this->catchDate;
    }
    public function jsonSerialize(): array {
        return [
            'fish_id' => $this->fishId,
            'fish_name' => $this->fishName,
            'map_id' => $this->mapId,
            'map_name' => $this->mapName,
            'max_length' => $this->maxLength,
            'max_weight' => $this->maxWeight
        ];
    }
}