<?php

namespace App\Infrastructure\Persistence\Equip;

use Exception;

class UserEquipDBException extends Exception
{
    protected $code = "5001";
    protected $message = "USER EQUIP DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}