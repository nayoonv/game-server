<?php

namespace App\Service\UserEquip;

use Exception;
class InvalidEquipException extends Exception
{
    protected $code = "6002";
    protected $message = "장비 변경을 위해 선택한 아이템이 장비가 아님";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}