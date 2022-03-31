<?php

namespace App\Exception\Auction;

use App\Exception\Base\UrukException;

class AuctionNotExistsException extends UrukException
{
    protected $code = "9001";
    protected $message = "auction 정보가 존재하지 않습니다.";
}