<?php

namespace App\Exception\Book;

use App\Exception\Base\UrukException;

class BookPrizeDBException extends UrukException
{
    protected $code = "14000";
    protected $message = "Book Prize DB 오류";
}