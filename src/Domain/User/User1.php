<?php

namespace App\Domain\User;

use JsonSerializable;

class User1 implements JsonSerializable
{
    private int $userId;

    private int $level;

    private int $experience;

    private int $gold;

    private int $pearl;

    private int $fatigue;

    public function getUserId() {
        return $this->userId;
    }
    public function __construct($userId, $level, $experience, $gold, $pearl, $fatigue) {
        $this->userId = $userId;
        $this->level = $level;
        $this->experience = $experience;
        $this->gold = $gold;
        $this->pearl = $pearl;
        $this->fatigue = $fatigue;
    }

    public function jsonSerialize(): array
    {
        // TODO: Implement jsonSerialize() method.
        return [
            'user_id' => $this->userId,
            'level' => $this->level,
            'experience' => $this->experience,
            'gold' => $this->gold,
            'pearl' => $this->pearl,
            'fatigue' => $this->fatigue
        ];
    }
}