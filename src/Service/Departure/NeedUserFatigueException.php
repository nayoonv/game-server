<?php

namespace App\Service\Departure;

use Exception;

class NeedUserFatigueException extends Exception
{
    protected $message = "사용자 피로도가 출항하기에 부족합니다.";
    protected $code = "5001";

    public function response(): array {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}