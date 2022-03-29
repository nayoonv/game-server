<?php

namespace App\Exception\Map;

use App\Exception\Base\UrukException;

class MapDBException extends UrukException
{
    protected $code = "12000";
    protected $message = "Map DB 문제";
}