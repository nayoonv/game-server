<?php

namespace App\Infrastructure\Persistence\UserAccountUser;

use Exception;

class UserAccountUserDBException extends Exception
{
    protected $message = "user_account_user DB 오류";
    protected $code = "4000";

    public function response(): array {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}