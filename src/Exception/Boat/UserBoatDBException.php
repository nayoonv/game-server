<?php

namespace App\Exception\Boat;
use App\Exception\UrukException;

class UserBoatDBException extends UrukException
{
    protected $code = "11001";
    protected $message = "UserBoat DB 오류";
}