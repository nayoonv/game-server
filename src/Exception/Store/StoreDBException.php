<?php

namespace App\Exception\Store;
use App\Exception\Base\UrukException;

class StoreDBException extends UrukException
{
    protected $code = "13000";
    protected $message = "Store DB 오류";
}