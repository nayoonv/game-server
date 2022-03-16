<?php

namespace App\Infrastructure\Persistence\Map;

use App\Domain\Departure\DepartureInfo;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class UserMapDBRepository extends BaseDBRepository
{
    public function updateUserMap($userId, $mapId) {
        $query = "update user_fishing_place set map_id = :map_id where user_id = :user_id;";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);
            $sth->bindParam(':map_id', $mapId);
            $sth->execute();

            $this->db->commit();

        } catch(Exception $e) {

        }
    }

    public function findDepartureInfoByUserId($userId, $mapId) {
        $query = "select u.map_id, m.map_name, u.access_time, m.distance, m.cost_to_sail, m.time_to_sail, m.reduced_durability, s.fatigue, b.user_boat_durability, b.user_boat_fuel
                from user_fishing_place u 
                join map m on u.map_id = m.map_id 
                join user s on u.user_id = s.user_id
                join user_boat b on u.user_id = b.user_id
                where u.user_id = :user_id and u.map_id = :map_id;";

        try {

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);
            $sth->bindParam(':map_id', $mapId);

            $sth->execute();

            $result = $sth->fetch();

            if ($result) {
                $result = new DepartureInfo($result["map_id"], $result["map_name"], $result["access_time"]
                    , $result["distance"], $result["cost_to_sail"], $result["time_to_sail"]
                    , $result["reduced_durability"], $result["fatigue"], $result["user_boat_durability"]
                    , $result["user_boat_fuel"]);
            }

        } catch(Exception $e) {

        }
        return $result;
    }


    public function createUserMap($userId) {
        $query = "insert into user_fishing_place(user_id) values(:user_id)";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $this->db->commit();

        } catch(Exception $e) {

        }
    }
}