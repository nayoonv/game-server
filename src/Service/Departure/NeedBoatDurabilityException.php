<?php

namespace App\Service\Departure;
use Exception;

class NeedBoatDurabilityException extends Exception
{
    protected $message = "보로롱24호 내구도를 수리해야 합니다.";
    protected $code = "5001";

    public function exceptionResult(): array {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}