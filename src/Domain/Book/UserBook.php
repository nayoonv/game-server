<?php

namespace App\Domain\Book;

class UserBook
{
    private int $userId;
    private int $fishId;
    private string $catchDate;

    public function __construct($userId, $fishId, $catchDate) {
        $this->userId = $userId;
        $this->fishId = $fishId;
        $this->catchDate = $catchDate;
    }

    public function getFishId() {
        return $this->fishId;
    }
}