<?php

namespace App\Exception\GiftBox;

use App\Exception\Base\UrukException;

class UserGiftBoxDBException extends UrukException
{
    protected $code = "16000";
    protected $message = "USERGIFTBOX DB 오류";
}