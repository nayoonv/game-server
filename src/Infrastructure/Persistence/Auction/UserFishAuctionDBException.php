<?php

namespace App\Infrastructure\Persistence\Auction;

use App\Util\UrukException;

class UserFishAuctionDBException extends UrukException
{
    protected $code = "9000";
    protected $message = "User Fish Auction DB 오류";
}