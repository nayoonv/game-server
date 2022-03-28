<?php

namespace App\Service\Fish;

use App\Util\UrukException;

class NotUserFishWhileFishingException extends UrukException
{
    protected $code = "10001";
    protected $message = "정산할 물고기가 없음";
}