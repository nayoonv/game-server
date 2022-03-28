<?php

namespace App\Service\Boat;

use Exception;

class NotCreateUserBoatException extends Exception
{
    protected $code = "11003";
    protected $message = "사용자 보트 생성 실패";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}