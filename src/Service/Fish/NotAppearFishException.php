<?php

namespace App\Service\Fish;

use Exception;

class NotAppearFishException extends Exception
{
    protected $code = "40004";
    protected $message = "물고기가 나타나지를 않습니다.";

    public function exceptionResult() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}