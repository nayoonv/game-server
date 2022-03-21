<?php

namespace App\Domain\Boat;

class UserBoat
{
    private int $userBoatLevel;

    private int $userBoatDurability;

    private int $userBoatFuel;

    public function __construct($userBoatLevel, $userBoatDurability, $userBoatFuel) {
        $this->userBoatLevel = $userBoatLevel;
        $this->userBoatDurability = $userBoatDurability;
        $this->userBoatFuel = $userBoatFuel;
    }

    public function getUserBoatDurability() {
        return $this->userBoatDurability;
    }

    public function getuserBoatFuel() {
        return $this->userBoatFuel;
    }
}