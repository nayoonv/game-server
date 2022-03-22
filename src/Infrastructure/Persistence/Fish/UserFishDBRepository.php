<?php

namespace App\Infrastructure\Persistence\Fish;

use App\Domain\Book\UserBookWithMapInfo;
use PDOException;
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


        } catch(PDOException $exception) {
            throw new NotInsertUserFishException();
        }
        return $userFishId;
    }
    public function findBeforeCalUnchecked($userId) {
        $query = "select u.user_fish_id, f.fish_id, f.fish_name, u.freshness, u.catch_date, u.length, u.weight, u.before_cal 
                from user_fish u 
                join fish f on u.fish_id = f.fish_id 
                where user_id = :user_id and before_cal = 0";
        $result = array();

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $fishes = $sth->fetchAll();
            if ($fishes) {
                foreach($fishes as &$fish) {
                    $userFish = new UserFish($fish['fish_id'], $fish['fish_name'], $fish['freshness']
                        , $fish['catch_date'], $fish['length'], $fish['weight'], $fish['before_cal']);
                    $userFish->setUserFishId($fish['user_fish_id']);
                    array_push($result, $userFish);
                }
            }
        } catch(PDOException $exception) {
            throw new UserFishDBException();
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

        } catch(PDOException $exception) {
            throw new UserFishDBException();
        }
    }
    public function findNotInUserBookByUserId($userId) {
        $query = " select f.fish_id, u.catch_date, f.fish_name, f.max_length, f.max_weight, m.map_id, m.map_name 
                from user_fish u
                join fish f on u.fish_id = f.fish_id
                join map m on f.map_id = m.map_id
                where user_id = :user_id
                and f.fish_id not in (select fish_id from user_book b where b.user_id = :user_id) 
                order by u.catch_date limit 1;";

        $result = array();

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_id', $userId);
            $sth->execute();

            $fishes = $sth->fetchAll();
            if ($fishes) {
                foreach($fishes as &$fish) {
                    $userFish = new UserBookWithMapInfo($fish['fish_id'], $fish['fish_name'], $fish['map_id']
                        , $fish['map_name'], $fish['max_length'], $fish['max_weight']);
                    $userFish->setCatchDate($fish['catch_date']);
                    array_push($result, $userFish);
                }
            }
        } catch(PDOException $exception) {
            throw new UserFishDBException();
        }
        return $result;
    }

    /**
     * @throws UserFishDBException
     */
    public function findByUserFishId($userFishId) {
        $query = "select u.user_fish_id, f.fish_id, f.fish_name, u.freshness, u.catch_date, u.length, u.weight, u.before_cal 
                from user_fish u 
                join fish f on u.fish_id = f.fish_id 
                where user_fish_id = :user_fish_id";

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam('user_fish_id', $userFishId);
            $sth->execute();

            $result = $sth->fetch();
            if ($result) {
                $fish = new UserFish($result['fish_id'], $result['fish_name'], $result['freshness']
                    , $result['catch_date'], $result['length'], $result['weight'], $result['before_cal']);
                $fish->setUserFishId($result['user_fish_id']);
                $result = $fish;
            }
            return $result;
        } catch(PDOException $exception) {
            throw new UserFishDBException();
        }
    }

    /**
     * @throws UserFishDBException
     */
    public function deleteByUserFishId($userFishId) {
        $query = "delete from user_fish where user_fish_id = :user_fish_id";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam('user_fish_id', $userFishId);
            $sth->execute();

            $this->db->commit();
        } catch(PDOException $exception) {
            throw new UserFishDBException();
        }
    }
}