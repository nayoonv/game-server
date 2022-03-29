<?php

namespace App\Exception\Map;

use Exception;

class NotCreateUserMapException extends Exception
{
    protected $code = "12002";
    protected $message = "사용자 USER MAP 생성 오류";
}