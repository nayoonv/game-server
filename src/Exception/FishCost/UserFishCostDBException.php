<?php

namespace App\Exception\FishCost;
use App\Exception\Base\UrukException;

class UserFishCostDBException extends UrukException
{
    protected $code = "9000";
    protected $message = "경매 관련 DB 오류";

}