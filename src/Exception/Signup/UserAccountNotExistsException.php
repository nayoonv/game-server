<?php

namespace App\Exception\Signup;

use App\Exception\Base\UrukException;

class UserAccountNotExistsException extends UrukException
{
    protected $code = "3003";
    protected $message = "가입 실패";
}