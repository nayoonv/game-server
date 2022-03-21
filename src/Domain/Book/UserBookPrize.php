<?php

namespace App\Domain\Book;

class UserBookPrize
{
    private int $userId;

    private int $bookPrizeId;

    private string $getDate;

    public function __construct($userId, $bookPrizeId, $getDate) {
        $this->userId = $userId;
        $this->bookPrizeId = $bookPrizeId;
        $this->getDate = $getDate;
    }

    public function getBookPrizeId() {
        return $this->bookPrizeId;
    }

}