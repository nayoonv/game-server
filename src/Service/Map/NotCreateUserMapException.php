<?php

namespace App\Service\Map;

use Exception;

class NotCreateUserMapException extends Exception
{
    protected $code = "12002";
    protected $message = "가입한 이력이 있는 이메일 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}