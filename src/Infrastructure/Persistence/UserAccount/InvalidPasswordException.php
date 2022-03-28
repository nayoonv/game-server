<?php

namespace App\Infrastructure\Persistence\UserAccount;

use Exception;

class InvalidPasswordException extends Exception
{
    protected $code = "4003";
    protected $message = "비밀번호가 올바르지 않음";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}