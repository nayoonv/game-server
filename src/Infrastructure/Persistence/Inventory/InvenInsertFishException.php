<?php

namespace App\Infrastructure\Persistence\Inventory;

use Exception;

class InvenInsertFishException extends Exception
{
    protected $code = "50505";
    protected $message = "인벤토리에 물고기를 넣는데 실패";

    public function exceptionResult() {
        return [
            'code' => $this->code,
            'message' => $this->message
            ];
    }
}