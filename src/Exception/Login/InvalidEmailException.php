<?php

namespace App\Exception\Login;

use App\Exception\Base\UrukException;

class InvalidEmailException extends UrukException
{
    protected $code = "4002";
    protected $message = "이메일이 올바르지 않음";
}