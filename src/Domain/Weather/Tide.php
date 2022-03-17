<?php

namespace App\Domain\Weather;

class Tide
{
    private string $tideTime;

    private int $tideType;

    private int $tidePower;

    public function getTideTime() {
        return $this->tideTime;
    }
    public function getTideType() {
        return $this->tideType;
    }

    public function getTidePower() {
        return $this->tidePower;
    }

    public function __construct($tideTime, $tideType, $tidePower) {
        $this->tideTime = $tideTime;
        $this->tideType = $tideType;
        $this->tidePower = $tidePower;
    }

    public function jsonSerialize() {
        return array([
            "tide_time" => $this->tideTime,
            "tide_type" => $this->tideType,
            "tide_power" => $this->tidePower
        ]);
    }
}