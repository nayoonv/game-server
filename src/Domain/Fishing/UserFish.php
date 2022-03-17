<?php

namespace App\Domain\Fishing;

class UserFish
{
    private int $userFishId;

    private int $fishId;

    private string $fishName;

    private int $freshness;

    private string $catchDate;

    private int $length;

    private int $weight;

    private int $beforeCal;

    public function __construct($fishId, $fishName, $freshness, $catchDate, $length, $weight, $beforeCal) {
        $this->fishId = $fishId;
        $this->fishName = $fishName;
        $this->freshness = $freshness;
        $this->catchDate = $catchDate;
        $this->length = $length;
        $this->weight = $weight;
        $this->beforeCal = $beforeCal;
    }

    public function setUserFishId($userFishId) {
        $this->userFishId = $userFishId;
    }
    public function getFishId() {
        return $this->fishId;
    }
    public function getLength() {
        return $this->length;
    }
    public function getWeight() {
        return $this->weight;
    }

    public function jsonSerialize(): array {
        return [
            'user_fish_id' => $this->userFishId,
            'fish_id' => $this->fishId,
            'fish_name' => $this->fishName,
            'freshness' => $this->freshness,
            'catch_date' => $this->catchDate,
            'length' => $this->length,
            'weight' => $this->weight,
            'before_cal' => $this->beforeCal
        ];
    }
}