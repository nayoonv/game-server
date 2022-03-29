<?php

namespace App\Exception\Book;

use App\Exception\Base\UrukException;

class EquipNotExistsException extends UrukException
{
    protected $code = "5002";
    protected $message = "Equip이 존재하지 않음";
}