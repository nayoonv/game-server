<?php

namespace App\Infrastructure\Persistence\Book;

use App\Util\UrukException;

class BookPrizeNotExistsException extends UrukException
{
    protected $code = "14003";
    protected $message = "존재하지 않은 book_prize_id";
}