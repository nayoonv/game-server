<?php

namespace App\Domain\UserAccount;

use JsonSerializable;

class LoginUser implements JsonSerializable
{
    private int $userId;

    private int $nationId;

    private int $languageId;

    private int $level;

    private int $experience;

    private int $gold;

    private int $pearl;

    private int $fatigue;

    public function __construct($nationId, $languageId, $userId, $level, $experience, $gold, $pearl, $fatigue) {
        $this->nationId = $nationId;
        $this->languageId = $languageId;
        $this->userId = $userId;
        $this->level = $level;
        $this->experience = $experience;
        $this->gold = $gold;
        $this->pearl = $pearl;
        $this->fatigue = $fatigue;
    }

    public function jsonSerialize(): array
    {
        return [
            'nation_id' => $this->nationId,
            'language_id' => $this->languageId,
            'user_id' => $this->userId,
            'level' => $this->level,
            'experience' => $this->experience,
            'gold' => $this->gold,
            'pearl' => $this->pearl,
            'fatigue' => $this->fatigue
        ];
    }
}