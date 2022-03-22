<?php

namespace App\Domain\Equip;
use JsonSerializable;

class CurrentRod implements JsonSerializable
{
    private int $rodId;

    private string $rodName;

    private int $rodGradeId;

    private string $rodGradeName;

    private int $rodTypeId;

    private string $rodTypeName;

    private int $hardness;

    private int $hookingProbability;

    private int $successProbability;

    private int $rodLevel;

    private int $rodDurability;

    public function __construct($rodId, $rodName, $rodGradeId, $rodGradeName, $rodTypeId, $rodTypeName
        , $hardness, $hookingProbability, $successProbability, $rodLevel, $rodDurability) {
        $this->rodId = $rodId;
        $this->rodName = $rodName;
        $this->rodGradeId = $rodGradeId;
        $this->rodGradeName = $rodGradeName;
        $this->rodTypeId = $rodTypeId;
        $this->rodTypeName = $rodTypeName;
        $this->hardness = $hardness;
        $this->hookingProbability = $hookingProbability;
        $this->successProbability = $successProbability;
        $this->rodLevel = $rodLevel;
        $this->rodDurability = $rodDurability;
    }

    public function getRodName() {
        return $this->rodName;
    }
    public function getRodTypeName() {
        return $this->rodTypeName;
    }
    public function getRodTypeId() {
        return $this->rodTypeId;
    }
    public function getRodGradeName() {
        return $this->rodGradeName;
    }
    public function getRodGradeId() {
        return $this->rodGradeId;
    }
    public function getHardNess() {
        return $this->hardness;
    }
    public function getHookingProbability() {
        return $this->hookingProbability;
    }
    public function getSuccessProbability() {
        return $this->successProbability;
    }
    public function getRodLevel() {
        return $this->rodLevel;
    }
    public function getRodDurability() {
        return $this->rodDurability;
    }
    public function jsonSerialize(): array {
        return [
            'user_rod_id' => $this->rodId,
            'user_rod_name' => $this->rodName,
            'user_rod_grade_name' => $this->rodGradeName,
            'user_rod_type_name' => $this->rodTypeName,
            'user_rod_level' => $this->rodLevel
        ];
    }
}