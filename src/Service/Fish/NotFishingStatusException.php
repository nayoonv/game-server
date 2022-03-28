<?php

namespace App\Service\Fish;

use App\Util\UrukException;

class NotFishingStatusException extends UrukException
{
    protected $message = "출항하지 않은 상태";
    protected $code = "8006";

}