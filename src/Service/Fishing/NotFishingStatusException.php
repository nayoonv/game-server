<?php

namespace App\Service\Fishing;

use Exception;

class NotFishingStatusException extends Exception
{
    protected $message = "현재 출항하지 않았습니다.";
    protected $code = "5001";

    public function exceptionResult(): array {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}