<?php

namespace App\Exception\Signup;

use App\Exception\Base\UrukException;

class NoEmailInputException extends UrukException
{
    protected $code = "3001";
    protected $message = "이메일 입력 오류";
}