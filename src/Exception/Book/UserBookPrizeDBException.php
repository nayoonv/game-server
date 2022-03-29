<?php

namespace App\Exception\Book;

use App\Exception\UrukException;

class UserBookPrizeDBException extends UrukException
{
    protected $code = "14005";
    protected $message = "USER BOOK PRIZE DB 오류";
}