<?php

namespace App\Infrastructure\Persistence\Book;

use App\Util\UrukException;

class UserBookDBException extends UrukException
{
    protected $code = "14001";
    protected $message = "User Book DB 오류";
}