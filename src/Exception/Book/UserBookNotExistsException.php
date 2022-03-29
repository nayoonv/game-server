<?php

namespace App\Exception\Book;

use App\Exception\UrukException;

class UserBookNotExistsException extends UrukException
{
    protected $code = "14004";
    protected $message = "유저 Book에 데이터가 존재하지 않음";
}