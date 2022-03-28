<?php

namespace App\Infrastructure\Persistence\Store;
use Exception;

class StoreDBException extends Exception
{
    protected $code = "13000";
    protected $message = "Store DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}