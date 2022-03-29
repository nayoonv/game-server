<?php

namespace App\Exception\Login;

use App\Exception\Base\UrukException;

class UserAccountUserDBException extends UrukException
{
    protected $message = "user_account_user DB 오류";
    protected $code = "4000";
}