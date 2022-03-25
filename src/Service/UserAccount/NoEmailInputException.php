<?php

namespace App\Service\UserAccount;

use Exception;

class NoEmailInputException extends Exception
{
    protected $code = "3001";
    protected $message = "이메일 입력 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}