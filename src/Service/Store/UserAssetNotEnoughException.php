<?php

namespace App\Service\Store;
use Exception;

class UserAssetNotEnoughException extends Exception
{
    protected $code = "13002";
    protected $message = "사용자 재화가 부족함";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}