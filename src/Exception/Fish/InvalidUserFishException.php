<?php

namespace App\Exception\Fish;

use App\Exception\UrukException;

class InvalidUserFishException extends UrukException
{
    protected $code = "15001";
    protected $message = "존재하지 않는 User Fish Id";
}