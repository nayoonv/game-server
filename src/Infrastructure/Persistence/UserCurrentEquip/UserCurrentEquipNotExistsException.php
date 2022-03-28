<?php

namespace App\Infrastructure\Persistence\UserCurrentEquip;

use Exception;

class UserCurrentEquipNotExistsException extends Exception
{
    protected $code = "5004";
    protected $message = "유저 장착 장비가 존재하지 않음";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}