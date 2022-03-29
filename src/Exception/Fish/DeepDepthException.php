<?php

namespace App\Exception\Fish;

use App\Exception\Base\UrukException;

class DeepDepthException extends UrukException
{
    protected $code = "8008";
    protected $message = "너무 깊게 낚싯대를 내렸다";
}