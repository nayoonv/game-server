<?php

namespace App\Exception\Fish;

use App\Exception\Base\UrukException;

class UserFishDBException extends UrukException
{
    protected $code = "15000";
    protected $message = "user_fish DB 오류";
}