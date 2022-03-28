<?php

namespace App\Infrastructure\Persistence\Inventory;
use Exception;

class InvenInsertEquipException extends Exception
{
    protected $code = "13004";
    protected $message = "인벤토리에 사용자 장비 추가 실패";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}