<?php

namespace App\Exception\Departure;

use App\Exception\Base\UrukException;

class UserLevelLimitException extends UrukException
{
    protected $message = "사용자 레벨에선 해당 지역에 접근할 수 없습니다.";
    protected $code = "7004";
}