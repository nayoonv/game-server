<?php

namespace App\Infrastructure\Persistence\Weather;
use Exception;

class TideDBException extends Exception
{
    protected $code = "8001";
    protected $message = "Tide DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}