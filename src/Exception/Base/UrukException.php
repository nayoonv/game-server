<?php

namespace App\Exception\Base;

use Exception;

class UrukException extends Exception
{
    protected $code;
    protected $message;

    public function response() {
        return [
            "code" => $this->code,
            "message" => $this->message
        ];
    }
}