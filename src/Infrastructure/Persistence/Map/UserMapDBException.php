<?php

namespace App\Infrastructure\Persistence\Map;

use App\Util\UrukException;

class UserMapDBException extends UrukException
{
    protected $code = "12001";
    protected $message = "UserMap DB 오류";
}