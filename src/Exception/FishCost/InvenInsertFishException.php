<?php

namespace App\Exception\Fish;

use App\Exception\Base\UrukException;

class InvenInsertFishException extends UrukException
{
    protected $code = "8005";
    protected $message = "인벤토리에 사용자가 잡은 물고기를 저장하는데 실패";
}