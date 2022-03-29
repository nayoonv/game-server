<?php

namespace App\Exception\Weather;

use App\Exception\UrukException;

class WeatherDBException extends UrukException
{
    protected $code = "8000";
    protected $message = "Weather DB 오류";
}