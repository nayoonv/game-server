<?php

namespace App\Infrastructure\Persistence\Equip;

use Exception;

class EquipDBException extends Exception
{
    protected $code = "5000";
    protected $message = "EQUIP DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}