<?php

namespace App\Domain\Fishing;

class FishingFish
{
    private int $fishId;

    private string $fishName;

    private int $fishGradeId;

    private int $length;

    private int $weight;

    public function __construct($fishId, $fishName, $fishGradeId, $length, $weight) {
        $this->fishId = $fishId;
        $this->fishName = $fishName;
        $this->fishGradeId = $fishGradeId;
        $this->length = $length;
        $this->weight = $weight;
    }

    public function getFishId() {
        return $this->fishId;
    }

    public function getFishName() {
        return $this->fishName;
    }

    public function getLength() {
        return $this->length;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function jsonSerialize(): array {
        return [
            'fish_id' => $this->fishId,
            'fish_name' => $this->fishName,
            'fish_grade_id' => $this->fishGradeId,
            'length' => $this->length,
            'weight' => $this->weight
        ];
    }
}