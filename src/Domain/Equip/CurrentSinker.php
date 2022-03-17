<?php

namespace App\Domain\Equip;

class CurrentSinker
{
    private int $sinkerId;

    private string $sinkerName;

    private int $sinkerWeight;

    public function __construct($sinkerId, $sinkerName, $sinkerWeight)
    {
        $this->sinkerId = $sinkerId;
        $this->sinkerName = $sinkerName;
        $this->sinkerWeight = $sinkerWeight;
    }

    public function getSinkerName()
    {
        return $this->sinkerName;
    }

    public function getSinkerWeight()
    {
        return $this->sinkerWeight;
    }

    public function jsonSerialize(): array
    {
        return [
            'user_sinker_id' => $this->sinkerId,
            'user_sinker_name' => $this->sinkerName,
        ];
    }
}