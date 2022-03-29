<?php

namespace App\Exception\Login;

use App\Exception\UrukException;

class InvalidPasswordException extends UrukException
{
    protected $code = "4003";
    protected $message = "비밀번호가 올바르지 않음";
}