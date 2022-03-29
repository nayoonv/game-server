<?php

namespace App\Exception\Weather;

use App\Exception\Base\UrukException;

class TideDBException extends UrukException
{
    protected $code = "17001";
    protected $message = "Tide DB 오류";
}