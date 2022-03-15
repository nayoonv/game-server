<?php

namespace App\Domain\Weather;

class Weather
{
    private string $time;

    private int $temperature;

    private int $windDirectionId;

    private int $windSpeed;

    private int $tideType;

    private int $tidePower;

    public function getTime() {
        return $this->time;
    }

    public function getTemperature() {
        return $this->temperature;
    }

    public function getWindDirectionId() {
        return $this->windDirectionId;
    }

    public function getWindSpeed() {
        return $this->windSpeed;
    }

    public function getTideType() {
        return $this->tideType;
    }

    public function getTidePower() {
        return $this->tidePower;
    }

    public function __construct($time, $temperature, $windDirectionId, $windSpeed, $tideType, $tidePower) {
        $this->time = $time;
        $this->temperature = $temperature;
        $this->windDirectionId = $windDirectionId;
        $this->windSpeed= $windSpeed;
        $this->tideType = $tideType;
        $this->tidePower = $tidePower;
    }

    public function jsonSerialize(): array
    {
        return [
            'time' => $this->time,
            'temperature' => $this->temperature,
            'wind_direction_id' => $this->windDirectionId,
            'wind_speed' => $this->windSpeed,
            'tide_type' => $this->tideType,
            'tide_power' => $this->tidePower
        ];
    }
}