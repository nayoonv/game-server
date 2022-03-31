<?php

namespace App\Domain\Fishing;

class AuctionFish
{
    private int $fishGradeId;

    private int $maxWeight;

    private int $maxLength;

    private int $price;

    public function __construct($fishGradeId, $maxWeight, $maxLength, $price) {
        $this->fishGradeId = $fishGradeId;
        $this->maxWeight = $maxWeight;
        $this->maxLength = $maxLength;
        $this->price = $price;
    }

    public function getMaxLength() {
        return $this->maxLength;
    }
    public function getMaxWeight() {
        return $this->maxWeight;
    }
    public function getFishGradeId() {
        return $this->fishGradeId;
    }
    public function getPrice() {
        return $this->price;
    }
}