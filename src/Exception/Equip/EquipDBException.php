<?php

namespace App\Exception\Equip;

use App\Exception\UrukException;

class EquipDBException extends UrukException
{
    protected $code = "5000";
    protected $message = "EQUIP DB 오류";
}