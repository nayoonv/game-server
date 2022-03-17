<?php

namespace App\Domain\Fishing;

class Fish
{
    private int $fishId;

    private string $fishName;

    private int $fishGradeId;

    private int $maxLength;

    private int $maxWeight;

    public function __construct($fishId, $fishName, $fishGradeId, $maxLength, $maxWeight) {
        $this->fishId = $fishId;
        $this->fishName = $fishName;
        $this->fishGradeId = $fishGradeId;
        $this->maxLength = $maxLength;
        $this->maxWeight = $maxWeight;
    }

    public function getFishId() {
        return $this->fishId;
    }
    public function getFishName() {
        return $this->fishName;
    }
    public function getMaxLength() {
        return $this->maxLength;
    }
    public function getMaxWeight() {
        return $this->maxWeight;
    }
    public function jsonSerialize() : array {
        return [
            'fish_id' => $this->fishId,
            'fish_name' => $this->fishName,
            'fish_grade_id' => $this->fishGradeId,
            'max_length' => $this->maxLength,
            'max_weight' => $this->maxWeight
        ];
    }
}