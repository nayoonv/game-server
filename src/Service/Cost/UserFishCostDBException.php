<?php

namespace App\Service\Cost;
use Exception;

class UserFishCostDBException extends Exception
{
    protected $code = "5003";
    protected $message = "user fish cost db 오류";

    public function response(): array {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}