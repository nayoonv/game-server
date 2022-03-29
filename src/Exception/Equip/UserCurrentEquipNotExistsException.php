<?php

namespace App\Exception\Equip;

use App\Exception\Base\UrukException;

class UserCurrentEquipNotExistsException extends UrukException
{
    protected $code = "5004";
    protected $message = "유저 장착 장비가 존재하지 않음";
}