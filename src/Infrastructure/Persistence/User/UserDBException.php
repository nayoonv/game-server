<?php

namespace App\Infrastructure\Persistence\User;

use Exception;

class UserDBException extends Exception
{
    protected $code = "4001";
    protected $message = "USER DB 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}