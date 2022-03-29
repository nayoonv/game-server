<?php

namespace App\Exception\Fish;

use App\Exception\Base\UrukException;

class FishDBException extends UrukException
{
    protected $code = "15002";
    protected $message = "Fish DB 오류";
}