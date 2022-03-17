<?php

namespace App\Infrastructure\Persistence\Fish;

use App\Infrastructure\Persistence\Base\BaseDBRepository;

class UserFishDBRepository extends BaseDBRepository
{
    public function insertUserFish($userId, $fishId, $length, $weight, $catchDate) {
        $query = "insert into user_fish(user_id, fish_id, length, weight, catch_date) values (:user_id, :fish_id, :length, :weight, :catch_date)";
        $userFishId = false;
        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);
            $sth->bindParam(':fish_id', $fishId);
            $sth->bindParam(':length', $length);
            $sth->bindParam(':weight', $weight);
            $sth->bindParam(':catch_date', $catchDate);

            $sth->execute();

            $userFishId = $this->db->lastInsertId();

            $this->db->commit();


        } catch(NotInsertUserFishException $exception) {

        }
        return $userFishId;
    }

//    public function findUserFishByUserFishId($userFishId) {
//        $query = "select catch_date from "
//    }
}