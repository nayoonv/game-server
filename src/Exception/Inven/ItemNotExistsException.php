<?php

namespace App\Exception\Inven;
use App\Exception\Base\UrukException;

class ItemNotExistsException extends UrukException
{
    protected $code = "6001";
    protected $message = "인벤토리 내 해당 데이터가 존재하지 않음";
}