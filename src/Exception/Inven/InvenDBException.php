<?php

namespace App\Exception\Inven;

use App\Exception\Base\UrukException;

class InvenDBException extends UrukException
{
    protected $code = "6000";
    protected $message = "인벤토리 DB 오류";
}