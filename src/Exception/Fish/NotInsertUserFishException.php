<?php

namespace App\Exception\Fish;

use App\Exception\Base\UrukException;

class NotInsertUserFishException extends UrukException
{
    protected $code = "8004";
    protected $message = "사용자가 잡은 물고기 저장에 실패하였습니다.";
}