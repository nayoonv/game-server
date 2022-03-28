<?php

namespace App\Service\Store;
use Exception;

class UserEquipInsertException extends Exception
{
    protected $code = "13003";
    protected $message = "사용자 장비 추가 실패";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}