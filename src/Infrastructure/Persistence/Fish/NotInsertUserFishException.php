<?php

namespace App\Infrastructure\Persistence\Fish;

use Exception;

class NotInsertUserFishException extends Exception
{
    protected $code = "40004";
    protected $message = "사용자가 잡은 물고기 저장에 실패하였습니다.";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}