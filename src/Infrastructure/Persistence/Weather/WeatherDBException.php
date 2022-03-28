<?php

namespace App\Infrastructure\Persistence\Weather;
use Exception;

class WeatherDBException extends Exception
{
    protected $code = "8000";
    protected $message = "Weather DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}