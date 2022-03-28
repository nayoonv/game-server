<?php

namespace App\Service\Cost;
use App\Util\UrukException;

class UserFishCostDBException extends UrukException
{
    protected $code = "15002";
    protected $message = "user fish cost db 오류";

}