<?php

namespace App\Domain\UserGiftBox;

class UserGiftBox
{
    private int $userGiftBoxId;

    private int $userId;

    private int $giftTypeId;

    private int $giftId;

    private int $count;

    private string $receivedDate;

    private int $received;

    public function __construct($userGiftBoxId, $userId, $giftTypeId, $giftId
        ,                       $count, $receivedDate, $received)
    {
        $this->userGiftBoxId = $userGiftBoxId;
        $this->userId = $userId;
        $this->giftTypeId = $giftTypeId;
        $this->itemId = $giftId;
        $this->count = $count;
        $this->receivedDate = $receivedDate;
        $this->received = $received;
    }

    public function jsonSerialize()
    {
        return [
            'user_gift_box_id' => $this->userGiftBoxId,
            'gift_type_id' => $this->giftTypeId,
            'gift_id' => $this->giftId,
            'count' => $this->count,
            'received_date' => $this->receivedDate,
            'received' => $this->received
        ];
    }
}