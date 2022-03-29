<?php

namespace App\Exception\Signup;

use App\Exception\Base\UrukException;

class UserAccountDBException extends UrukException
{
    protected $code = "3000";
    protected $message = "USER ACCOUNT DB 오류";
}