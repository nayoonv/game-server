<?php

namespace App\Infrastructure\Persistence\Map;

use Exception;

class MapDBException extends Exception
{
    protected $code = "12000";
    protected $message = "Map DB 문제";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}