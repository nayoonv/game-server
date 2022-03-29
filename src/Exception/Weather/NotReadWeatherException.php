<?php

namespace App\Exception\Weather;

use App\Exception\UrukException;

class NotReadWeatherException extends UrukException
{
    protected $code = "8002";
    protected $message = "날씨 정보가 존재하지 않음";
}