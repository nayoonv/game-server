<?php

namespace App\Exception\Weather;

use App\Exception\Base\UrukException;

class WeatherDBException extends UrukException
{
    protected $code = "17000";
    protected $message = "Weather DB 오류";
}