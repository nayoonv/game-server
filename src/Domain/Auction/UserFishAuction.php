<?php

namespace App\Domain\Auction;

use JsonSerializable;

class UserFishAuction implements JsonSerializable
{
    private int $userId;

    private int $gold;

    private string $sellDate;

    public function __construct($userId, $gold, $sellDate) {
        $this->userId = $userId;
        $this->gold = $gold;
        $this->sellDate = $sellDate;
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
        return [
            'user_id' => $this->userId,
            'gold' => $this->gold,
            'sell_date' => $this->sellDate
        ];
    }
}