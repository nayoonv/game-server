<?php

namespace App\Exception\Equip;
use App\Exception\Base\UrukException;

class UserCurrentEquipDBException extends UrukException
{
    protected $code = "5003";
    protected $message = "USER CURRENT EQUIP DB 오류";
}