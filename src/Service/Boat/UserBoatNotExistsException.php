<?php

namespace App\Service\Boat;

use Exception;

class UserBoatNotExistsException extends Exception
{
    protected $code = "11002";
    protected $message = "사용자 보트가 존재하지 않음";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}