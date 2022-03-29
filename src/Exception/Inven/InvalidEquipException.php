<?php

namespace App\Exception\Inven;

use App\Exception\Base\UrukException;

class InvalidEquipException extends UrukException
{
    protected $code = "6002";
    protected $message = "장비 변경을 위해 선택한 아이템이 장비가 아님";
}