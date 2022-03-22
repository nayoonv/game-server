<?php

namespace App\Service\Weather;

use Exception;

class NotReadWeatherException extends Exception
{
    protected $code = "1111";
    protected $message = "날씨 정보를 가져오지 못했습니다.";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}