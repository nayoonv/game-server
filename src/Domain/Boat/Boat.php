<?php

namespace App\Domain\Boat;

class Boat
{
    private int $userBoatLevel;

    private int $userBoatDurability;

    private int $userBoatFuel;

    public function __construct($userBoatLevel, $userBoatDurability, $userBoatFuel) {
        $this->userBoatLevel = $userBoatFuel;
        $this->userBoatDurability = $userBoatDurability;
        $this->userBoatFuel = $userBoatFuel;
    }

    public function jsonSerialize(): array {
        return [
            "user_boat_level" => $this->userBoatLevel,
            "user_boat_durability" => $this->userBoatDurability,
            "user_boat_fuel" => $this->userBoatFuel
        ];
    }
}