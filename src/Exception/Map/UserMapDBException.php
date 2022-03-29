<?php

namespace App\Exception\Map;

use App\Exception\UrukException;

class UserMapDBException extends UrukException
{
    protected $code = "12001";
    protected $message = "UserMap DB 오류";
}