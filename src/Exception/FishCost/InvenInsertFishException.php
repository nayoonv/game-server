<?php

namespace App\Exception\Fish;

use App\Exception\UrukException;

class InvenInsertFishException extends UrukException
{
    protected $code = "8010";
    protected $message = "인벤토리에 사용자가 잡은 물고기를 저장하는데 실패";
}