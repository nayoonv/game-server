<?php

namespace App\Domain\Book;

class BookPrize
{
    private int $bookPrizeId;

    private int $fishCount;

    private int $assetId;

    private int $cost;

    public function __construct($bookPrizeId, $fishCount, $assetId, $cost) {
        $this->bookPrizeId = $bookPrizeId;
        $this->fishCount = $fishCount;
        $this->assetId = $assetId;
        $this->cost = $cost;
    }

    public function getBookPrizeId() {
        return $this->bookPrizeId;
    }

    public function getFishCount() {
        return $this->fishCount;
    }

    public function getAssetId() {
        return $this->assetId;
    }

    public function getCost() {
        return $this->cost;
    }
}