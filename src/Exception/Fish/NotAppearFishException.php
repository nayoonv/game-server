<?php

namespace App\Exception\Fish;

use App\Exception\Base\UrukException;

class NotAppearFishException extends UrukException
{
    protected $code = "8007";
    protected $message = "물고기가 나타나지를 않습니다.";
}