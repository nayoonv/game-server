<?php

namespace App\Infrastructure\Persistence\Equip;

use Exception;

class EquipNotExistsException extends Exception
{
    protected $code = "5002";
    protected $message = "Equip이 존재하지 않음";

    public function __construct($type)  {
        parent::__construct($this->message, $this->code);
        $this->message .= "type: ".$type;
    }
    public function response() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}