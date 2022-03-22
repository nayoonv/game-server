<?php

namespace App\Infrastructure\Persistence\Fish;

use Exception;

class UserFishDBException extends Exception
{
    protected $code = "10101010";
    protected $message = "user_fish 테이블 오류";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}