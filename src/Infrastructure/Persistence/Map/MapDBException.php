<?php

namespace App\Infrastructure\Persistence\Map;

use Exception;

class MapDBException extends Exception
{
    public $code = "2000";
    public $message = "지도 DB 문제";
}