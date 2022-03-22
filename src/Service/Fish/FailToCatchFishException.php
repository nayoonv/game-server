<?php

namespace App\Service\Fish;

use Exception;

class FailToCatchFishException extends Exception
{
    protected $code = "4004";
    protected $message = "물고기가 등장하지 않았습니다.";

    public function exceptionResult() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}