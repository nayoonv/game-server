<?php

namespace App\Domain\Weather;
use JsonSerializable;

class Weather implements JsonSerializable
{
    private string $time;

    private int $temperature;

    private int $windDirectionId;

    private int $windSpeed;

    private string $tideTime;

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

    public function getTideTime() {
        return $this->tideTime;
    }

    public function getTideType() {
        return $this->tideType;
    }

    public function getTidePower() {
        return $this->tidePower;
    }

    public function __construct($time, $temperature, $windDirectionId, $windSpeed, $tideTime, $tideType, $tidePower) {
        $this->time = $time;
        $this->temperature = $temperature;
        $this->windDirectionId = $windDirectionId;
        $this->windSpeed= $windSpeed;
        $this->tideTime = $tideTime;
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
            'tide_time' => $this->tideTime,
            'tide_type' => $this->tideType,
            'tide_power' => $this->tidePower
        ];
    }
}