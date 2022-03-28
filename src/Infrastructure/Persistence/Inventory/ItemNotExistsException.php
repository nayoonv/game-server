<?php

namespace App\Infrastructure\Persistence\Inventory;
use Exception;

class ItemNotExistsException extends Exception
{
    protected $code = "6001";
    protected $message = "인벤토리 내 해당 데이터가 존재하지 않음";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}