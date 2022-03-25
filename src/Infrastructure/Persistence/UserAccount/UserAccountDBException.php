<?php

namespace App\Infrastructure\Persistence\UserAccount;

use Exception;

class UserAccountDBException extends Exception
{
    protected $code = "3000";
    protected $message = "USER ACCOUNT DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}