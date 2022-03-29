<?php

namespace App\Exception\Departure;
use App\Exception\UrukException;

class NeedBoatDurabilityException extends UrukException
{
    protected $message = "보로롱24호 내구도를 수리해야 합니다.";
    protected $code = "7003";
}