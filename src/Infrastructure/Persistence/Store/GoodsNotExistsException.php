<?php

namespace App\Infrastructure\Persistence\Store;
use Exception;
class GoodsNotExistsException extends Exception
{
    protected $code = "13001";
    protected $message = "해당 상품이 존재하지 않음";

    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}