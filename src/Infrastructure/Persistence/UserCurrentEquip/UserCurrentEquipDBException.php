<?php

namespace App\Infrastructure\Persistence\UserCurrentEquip;
use Exception;

class UserCurrentEquipDBException extends Exception
{
    protected $code = "5003";
    protected $message = "USER CURRENT EQUIP DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}