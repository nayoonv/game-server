<?php

namespace App\Exception\Signup;

use App\Exception\UrukException;

class DuplicateEmailException extends UrukException
{
    protected $code = "3002";
    protected $message = "가입한 이력이 있는 이메일 오류";
}