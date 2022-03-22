<?php

namespace App\Service\Cost;

use Exception;

class InvalidUserFishException extends Exception
{
    protected $code = "11111";
    protected $message = "user_fish_id에 해당하는 물고기가 존재하지 않습니다.";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}