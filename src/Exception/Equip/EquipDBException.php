<?php

namespace App\Exception\Equip;

use App\Exception\Base\UrukException;

class EquipDBException extends UrukException
{
    protected $code = "5000";
    protected $message = "EQUIP DB 오류";
}