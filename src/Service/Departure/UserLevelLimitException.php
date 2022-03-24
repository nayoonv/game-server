<?php

namespace App\Service\Departure;

use Exception;

class UserLevelLimitException extends Exception
{
    protected $message = "사용자 레벨에선 해당 지역에 접근할 수 없습니다.";
    protected $code = "5001";

    public function response(): array {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}