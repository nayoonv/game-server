<?php

namespace App\Service\Fish;

use Exception;

class DeepDepthException extends Exception
{
    protected $code = "5001";
    protected $message = "너무 깊게 낚싯대를 내렸다";

    public function exceptionResult(): array {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}