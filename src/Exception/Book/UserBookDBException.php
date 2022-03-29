<?php

namespace App\Exception\Book;

use App\Exception\UrukException;

class UserBookDBException extends UrukException
{
    protected $code = "14001";
    protected $message = "User Book DB 오류";
}