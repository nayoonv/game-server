<?php

namespace App\Exception\Store;
use App\Exception\Base\UrukException;

class InvenInsertEquipException extends UrukException
{
    protected $code = "13004";
    protected $message = "인벤토리에 사용자 장비 추가 실패";
}