<?php

namespace App\Exception\Store;
use App\Exception\Base\UrukException;

class UserEquipInsertException extends UrukException
{
    protected $code = "13003";
    protected $message = "사용자 장비 구매 실패";
}