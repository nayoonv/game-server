<?php

namespace App\Domain\Equip;

class CurrentLine
{
    private int $lineId;

    private string $lineName;

    private int $strength;

    private int $hookingProbability;

    private int $successProbability;

    private int $lineLevel;

    public function __construct($lineId, $lineName, $strength, $hookingProbability, $successProbability, $lineLevel) {
        $this->lineId = $lineId;
        $this->lineName = $lineName;
        $this->strength = $strength;
        $this->hookingProbability = $hookingProbability;
        $this->successProbability = $successProbability;
        $this->lineLevel = $lineLevel;
    }

    public function getLineName() {
        return $this->lineName;
    }
    public function getStrength() {
        return $this->strength;
    }
    public function getHookingProbability() {
        return $this->hookingProbability;
    }
    public function getSuccessProbability() {
        return $this->successProbability;
    }
    public function getLineLevel() {
        return $this->lineLevel;
    }
    public function jsonSerialize(): array {
        return [
            'user_line_id' => $this->lineId,
            'user_line_name' => $this->lineName,
            'user_line_level' => $this->lineLevel
        ];
    }
}