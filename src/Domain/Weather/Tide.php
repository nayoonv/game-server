<?php

namespace App\Domain\Weather;

class Tide
{
    private int $tideType;

    private int $tidePower;

    public function getTideType() {
        return $this->tideType;
    }

    public function getTidePower() {
        return $this->tidePower;
    }

    public function __construct($tideType, $tidePower) {
        $this->tideType = $tideType;
        $this->tidePower = $tidePower;
    }

    public function jsonSerialize() {
        return array([
            "tide_type" => $this->tideType,
            "tide_power" => $this->tidePower
        ]);
    }
}