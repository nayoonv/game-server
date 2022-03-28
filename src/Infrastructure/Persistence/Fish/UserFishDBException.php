<?php

namespace App\Infrastructure\Persistence\Fish;

use App\Util\UrukException;

class UserFishDBException extends UrukException
{
    protected $code = "15000";
    protected $message = "user_fish DB 오류";
}