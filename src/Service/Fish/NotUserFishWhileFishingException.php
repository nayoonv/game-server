<?php

namespace App\Service\Fish;

use Exception;

class NotUserFishWhileFishingException extends Exception
{
    protected $code = "4041";
    protected $message = "물고기를 한마리도 잡아오지 못했다.";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}