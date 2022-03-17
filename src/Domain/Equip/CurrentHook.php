<?php

namespace App\Domain\Equip;

class CurrentHook
{
    private int $hookId;

    private string $hookName;

    private int $appearanceProbability;

    private int $successProbability;

    public function __construct($hookId, $hookName, $appearanceProbability, $successProbability) {
        $this->hookId = $hookId;
        $this->hookName = $hookName;
        $this->appearanceProbability = $appearanceProbability;
        $this->successProbability = $successProbability;
    }

    public function getHookName() {
        return $this->hookName;
    }

    public function getAppearanceProbability() {
        return $this->appearanceProbability;
    }

    public function getSuccessProbability() {
        return $this->successProbability;
    }

    public function jsonSerialize(): array {
        return [
            'user_hook_id' => $this->hookId,
            'user_hook_name' => $this->hookName,
        ];
    }

}