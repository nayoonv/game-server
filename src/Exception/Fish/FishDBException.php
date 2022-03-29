<?php

namespace App\Exception\Fish;

use App\Exception\UrukException;

class FishDBException extends UrukException
{
    protected $code = "15002";
    protected $message = "Fish DB 오류";
}