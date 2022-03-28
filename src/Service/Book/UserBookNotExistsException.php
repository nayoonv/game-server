<?php

namespace App\Service\Book;

use App\Util\UrukException;

class UserBookNotExistsException extends UrukException
{
    protected $code = "14004";
    protected $message = "유저 Book에 데이터가 존재하지 않음";
}