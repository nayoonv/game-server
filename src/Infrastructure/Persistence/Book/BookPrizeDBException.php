<?php

namespace App\Infrastructure\Persistence\Book;

use App\Util\UrukException;

class BookPrizeDBException extends UrukException
{
    protected $code = "14000";
    protected $message = "Book Prize DB 오류";
}