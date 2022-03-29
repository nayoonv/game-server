<?php

namespace App\Exception\Map;

use App\Exception\Base\UrukException;

class MapNotExistsException extends UrukException
{
    protected $code = "12003";
    protected $message ="Map에 map id에 해당하는 데이터가 존재하지 않음";
}