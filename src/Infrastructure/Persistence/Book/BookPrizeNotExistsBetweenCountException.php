<?php

namespace App\Infrastructure\Persistence\Book;

use App\Util\UrukException;

class BookPrizeNotExistsBetweenCountException extends UrukException
{
    protected $code = "14002";
    protected $message = "입항 후 도감 Prize 획득 실패";
}