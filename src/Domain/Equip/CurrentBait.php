<?php

namespace App\Domain\Equip;

class CurrentBait
{
    private int $baitId;

    private string $baitName;

    private int $baitGradeId;

    private string $baitGradeName;

    private int $advancedAppearanceProbability;

    public function __construct($baitId, $baitName, $baitGradeId, $baitGradeName, $advancedAppearanceProbability) {
        $this->baitId = $baitId;
        $this->baitName = $baitName;
        $this->baitGradeId = $baitGradeId;
        $this->baitGradeName = $baitGradeName;
        $this->advancedAppearanceProbability = $advancedAppearanceProbability;
    }

    public function getBaitId() {
        return $this->baitId;
    }

    public function getBaitName() {
        return $this->baitName;
    }

    public function getBaitGradeName() {
        return $this->baitGradeName;
    }
    public function getBaitGradeId() {
        return $this->baitGradeId;
    }
    public function getAdvancedAppearanceProbability() {
        return $this->advancedAppearanceProbability;
    }
    public function jsonSerialize(): array {
        return [
            'user_bait_id' => $this->baitId,
            'user_bait_name' => $this->baitName,
            'user_bait_grade_name' => $this->baitGradeName
        ];
    }
}