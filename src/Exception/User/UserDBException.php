<?php

namespace App\Exception\User;

use App\Exception\UrukException;

class UserDBException extends UrukException
{
    protected $code = "4001";
    protected $message = "USER DB 오류";
}