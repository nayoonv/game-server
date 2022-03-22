<?php

namespace App\Infrastructure\Persistence\Inventory;

use Exception;

class InvenDBException extends Exception
{
    protected $code = "60006";
    protected $message = "인벤토리 DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}