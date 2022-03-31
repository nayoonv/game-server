<?php

namespace App\Exception\Fish;
use App\Exception\Base\UrukException;

class FishNotExistsException extends UrukException
{
    protected $code = "8010";
    protected $message = "해당하는 물고기는 존재하지 않습니다.";

}