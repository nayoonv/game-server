<?php

namespace App\Domain\Equip;

class CurrentReel
{
    private int $reelId;

    private string $reelName;

    private int $reelGradeId;

    private string $reelGradeName;

    private int $reelWindingAmount;

    private int $reelLevel;

    private int $reelDurability;

    public function __construct($reelId, $reelName, $reelGradeId, $reelGradeName, $reelWindingAmount, $reelLevel, $reelDurability) {
        $this->reelId = $reelId;
        $this->reelName = $reelName;
        $this->reelGradeId = $reelGradeId;
        $this->reelGradeName = $reelGradeName;
        $this->reelWindingAmount = $reelWindingAmount;
        $this->reelLevel = $reelLevel;
        $this->reelDurability = $reelDurability;
    }

    public function getReelName() {
        return $this->reelName;
    }

    public function getReelGradeName() {
        return $this->reelGradeName;
    }
    public function getReelGradeId() {
        return $this->reelGradeId;
    }
    public function getReelWindingAmount() {
        return $this->reelWindingAmount;
    }
    public function getReelLevel() {
        return $this->reelLevel;
    }
    public function getReelDurability() {
        return $this->reelDurability;
    }
    public function jsonSerialize(): array {
        return [
            'user_reel_id' => $this->reelId,
            'user_reel_name' => $this->reelName,
            'user_reel_grade_name' => $this->reelGradeName,
            'user_reel_level' => $this->reelLevel
        ];
    }
}