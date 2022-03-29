<?php

namespace App\Exception\Store;
use App\Exception\Base\UrukException;

class GoodsNotExistsException extends UrukException
{
    protected $code = "13001";
    protected $message = "해당 상품이 존재하지 않음";
}