<?php

namespace App\Exception\Departure;

use App\Exception\UrukException;

class NeedBoatFuelException extends UrukException
{
    protected $message = "보로롱24호 연료가 부족합니다.";
    protected $code = "7002";
}