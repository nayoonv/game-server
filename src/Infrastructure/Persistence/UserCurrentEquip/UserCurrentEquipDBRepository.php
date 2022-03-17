<?php

namespace App\Infrastructure\Persistence\UserCurrentEquip;

use App\Domain\UserCurrentEquip\UserCurrentEquip;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class UserCurrentEquipDBRepository extends BaseDBRepository
{
    public function findByUserId($userId) {
        $query = "select * from user_current_equip where user_id = :user_id";

        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $result = $sth->fetch();

            if ($result) {
                $result = new UserCurrentEquip($result['user_rod_id'], $result['user_line_id']
                    , $result['user_reel_id'], $result['user_hook_id'], $result['user_bait_id']
                    , $result['user_sinker_id']);
            }
        } catch (UserCurrentEquipNotExistsException $exception) {

        }

        return $result;
    }


}