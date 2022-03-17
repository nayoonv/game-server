<?php

namespace App\Domain\UserCurrentEquip;

use App\Domain\Equip\CurrentBait;
use App\Domain\Equip\CurrentHook;
use App\Domain\Equip\CurrentLine;
use App\Domain\Equip\CurrentReel;
use App\Domain\Equip\CurrentRod;
use App\Domain\Equip\CurrentSinker;

class UserCurrentEquipDetail
{
    private CurrentRod $rod;

    private CurrentLine $line;

    private CurrentReel $reel;

    private CurrentHook $hook;

    private CurrentBait $bait;

    private CurrentSinker $sinker;

    public function __construct($rod, $line, $reel, $hook, $bait, $sinker) {
        $this->rod = $rod;
        $this->line = $line;
        $this->reel = $reel;
        $this->hook = $hook;
        $this->bait = $bait;
        $this->sinker = $sinker;
    }

    public function getRod() {
        return $this->rod;
    }
    public function getLine() {
        return $this->line;
    }
    public function getReel() {
        return $this->reel;
    }
    public function getHook() {
        return $this->hook;
    }
    public function getBait() {
        return $this->bait;
    }
    public function getSinker() {
        return $this->sinker;
    }
    public function jsonSerialize(): array {
        $result = array_merge($this->rod->jsonSerialize(), $this->line->jsonSerialize(), $this->reel->jsonSerialize()
            , $this->hook->jsonSerialize(), $this->bait->jsonSerialize(), $this->sinker->jsonSerialize());
        return $result;
    }
}