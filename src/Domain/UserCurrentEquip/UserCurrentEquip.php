<?php

namespace App\Domain\UserCurrentEquip;

class UserCurrentEquip
{
    private int $user_rod_id;

    private int $user_line_id;

    private int $user_reel_id;

    private int $user_hook_id;

    private int $user_bait_id;

    private int $user_sinker_id;

    public function __construct($user_rod_id, $user_line_id, $user_reel_id, $user_hook_id, $user_bait_id, $user_sinker_id) {
        $this->user_rod_id = $user_rod_id;
        $this->user_line_id = $user_line_id;
        $this->user_reel_id = $user_reel_id;
        $this->user_hook_id = $user_hook_id;
        $this->user_bait_id = $user_bait_id;
        $this->user_sinker_id = $user_sinker_id;
    }

    public function getUserRodId() {
        return $this->user_rod_id;
    }
    public function getUserLineId() {
        return $this->user_line_id;
    }
    public function getUserReelId() {
        return $this->user_reel_id;
    }
    public function getUserHookId() {
        return $this->user_hook_id;
    }
    public function getUserBaitId() {
        return $this->user_bait_id;
    }
    public function getUserSinkerId() {
        return $this->user_sinker_id;
    }

}