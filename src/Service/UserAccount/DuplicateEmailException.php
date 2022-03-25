<?php

namespace App\Service\UserAccount;

use Exception;

class DuplicateEmailException extends Exception
{
    protected $code = "3002";
    protected $message = "가입한 이력이 있는 이메일 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}