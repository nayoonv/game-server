<?php

namespace App\Exception\Book;

use App\Exception\Base\UrukException;

class UserBookDBException extends UrukException
{
    protected $code = "14001";
    protected $message = "User Book DB 오류";
}