<?php

namespace App\Exception\Boat;

use App\Exception\Base\UrukException;

class UserBoatNotExistsException extends UrukException
{
    protected $code = "11002";
    protected $message = "사용자 보트가 존재하지 않음";
}