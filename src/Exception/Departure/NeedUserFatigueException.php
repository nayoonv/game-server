<?php

namespace App\Exception\Departure;

use App\Exception\Base\UrukException;

class NeedUserFatigueException extends UrukException
{
    protected $message = "사용자 피로도가 출항하기에 부족합니다.";
    protected $code = "7001";
}