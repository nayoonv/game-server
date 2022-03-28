<?php

namespace App\Infrastructure\Persistence\Boat;
use App\Util\UrukException;

class UserBoatDBException extends UrukException
{
    protected $code = "11001";
    protected $message = "UserBoat DB 오류";
}