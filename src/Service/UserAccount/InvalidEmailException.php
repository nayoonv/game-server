<?php

namespace App\Service\UserAccount;

use Exception;

class InvalidEmailException extends Exception
{
    protected $code = "4002";
    protected $message = "이메일이 올바르지 않음";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}