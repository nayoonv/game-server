<?php

namespace App\Exception\Equip;

use App\Exception\Base\UrukException;

class UserEquipDBException extends UrukException
{
    protected $code = "5001";
    protected $message = "USER EQUIP DB 오류";
}