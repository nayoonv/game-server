<?php

namespace App\Exception\Auction;

use App\Exception\UrukException;

class UserFishAuctionDBException extends UrukException
{
    protected $code = "9000";
    protected $message = "User Fish Auction DB 오류";
}