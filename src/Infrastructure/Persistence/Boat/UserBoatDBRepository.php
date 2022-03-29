<?php

namespace App\Infrastructure\Persistence\Boat;

use App\Domain\Boat\UserBoat;
use App\Exception\Base\UrukException;
use App\Exception\Boat\UserBoatDBException;
use App\Exception\Boat\UserBoatNotExistsException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class UserBoatDBRepository extends BaseDBRepository
{
    public function createUserBoat($userId) {
        $query = "insert into user_boat values(:user_id, 1, (select durability from boat_level where level = 1), (select fuel from boat_level where level = 1));";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $this->db->commit();

        } catch(Exception $e) {
            throw new UserBoatDBException();
        }
    }
    public function findByUserId($userId) {
        $query = "select * from user_boat where user_id = :user_id";
        $data = [
            ":user_id" => $userId
        ];
        $result = false;
        try {
            $sth = $this->db->prepare($query);
            $sth->execute($data);

            $result = $sth->fetch();
            if ($result) {
                $result = new UserBoat($result['user_boat_level'], $result['user_boat_durability'], $result['user_boat_fuel']);
                return $result;
            } else
                throw new UserBoatNotExistsException();
        } catch (Exception $exception) {
            throw new UserBoatDBException();
        } catch(UrukException $e) {
            throw $e;
        }
    }
    public function updateUserBoatDurability($userId, $mapId, $durability) {
        $query = "update user_boat set map_id = :map_id and user_boat_durability = :durability where user_id = :user_id;";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);
            $sth->bindParam(':map_id', $mapId);
            $sth->bindParam(':durability', $durability);
            $sth->execute();

            $this->db->commit();

        } catch(Exception $e) {
            throw new UserBoatDBException();
        }
    }
}