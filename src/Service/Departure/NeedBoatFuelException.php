<?php

namespace App\Service\Departure;

use Exception;

class NeedBoatFuelException extends Exception
{
    protected $message = "보로롱24호 연료가 부족합니다.";
    protected $code = "5001";

    public function response(): array {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}