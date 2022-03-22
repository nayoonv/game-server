<?php

namespace App\Service\Auction;

use Exception;

class UserFishAuctionDBException extends Exception
{
    protected $code = "2222";
    protected $message = "user_fish_auction DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}