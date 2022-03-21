<?php

namespace App\Domain\UserGiftBox;

class RequestUserGiftBox
{
    private int $userId;

    private int $giftTypeId;

    private int $giftId;

    private int $count;

    public function __construct($userId, $giftTypeId, $giftId, $count) {
        $this->userId = $userId;
        $this->giftTypeId = $giftTypeId;
        $this->itemId = $giftId;
        $this->count = $count;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getGiftTypeId() {
        return $this->giftTypeId;
    }

    public function getGiftId() {
        return $this->giftId;
    }

    public function getCount() {
        return $this->count;
    }
}