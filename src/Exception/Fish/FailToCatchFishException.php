<?php

namespace App\Exception\Fish;

use App\Exception\Base\UrukException;

class FailToCatchFishException extends UrukException
{
    protected $code = "8004";
    protected $message = "물고기를 낚지 못함";
}