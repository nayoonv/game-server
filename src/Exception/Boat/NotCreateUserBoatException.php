<?php

namespace App\Exception\Boat;


use App\Exception\UrukException;

class NotCreateUserBoatException extends UrukException
{
    protected $code = "11003";
    protected $message = "사용자 보트 생성 실패";
}