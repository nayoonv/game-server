<?php

namespace App\Infrastructure\Persistence\Fish;

use App\Domain\Fishing\UserFish;
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
    public function findBeforeCalUnchecked($userId) {
        $query = "select * from user_fish where user_id = :user_id and before_cal = 0";
        $result = array();

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $fishes = $sth->fetchAll();
            if ($fishes) {
                foreach($fishes as &$fish) {
                    array_push($result, new UserFish($fish['fish_id'], $fish['fish_name'], $fish['freshness']
                        , $fish['catch_date'], $fish['length'], $fish['weight'], $fish['before_cal']));
                }
            }
        } catch(UserFishDBException $exception) {

        }
        return $result;
    }

    public function updateBeforeCalChecked($userId) {
        $query = "update user_fish set before_cal = 1 where user_id = :user_id and before_cal = 0";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $this->db->commit();
        } catch(UserFishDBException $exception) {

        }
    }
//    public function findUserFishByUserFishId($userFishId) {
//        $query = "select catch_date from "
//    }
}