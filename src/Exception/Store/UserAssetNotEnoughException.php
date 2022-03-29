<?php

namespace App\Exception\Store;
use App\Exception\Base\UrukException;

class UserAssetNotEnoughException extends UrukException
{
    protected $code = "13002";
    protected $message = "사용자 재화가 부족함";
}