<?php

namespace App\Exception\Map;

use App\Exception\Base\UrukException;

class UserFishingPlaceNotExistsException extends UrukException
{
    protected $code = "12004";
    protected $message = "USER FISHING PLACE에 사용자 정보가 없음";
}