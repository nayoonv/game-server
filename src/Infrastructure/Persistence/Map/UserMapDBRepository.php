<?php

namespace App\Infrastructure\Persistence\Map;

use App\Domain\Departure\DepartureInfo;
use App\Domain\UserFishingPlace\UserFishingPlace;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use App\Service\Fish\NotFishingStatusException;
use App\Service\Map\NotCreateUserMapException;

class UserMapDBRepository extends BaseDBRepository
{
    public function updateUserMap($userId, $mapId)
    {
        $query = "update user_fishing_place set map_id = :map_id, fishing = 1 where user_id = :user_id;";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);
            $sth->bindParam(':map_id', $mapId);
            $sth->execute();

            $this->db->commit();

        } catch (Exception $e) {
            throw new UserMapDBException();
        }
    }

    public function updateFishingStatus($userId, $fishing)
    {
        $query = "update user_fishing_place set fishing = :fishing where user_id = :user_id;";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);
            $sth->bindParam(':fishing', $fishing);
            $sth->execute();

            $this->db->commit();

            $result = $sth->fetchColumn();
            if ($result <= 0)
                throw new NotFishingStatusException();

            return $result;
        } catch (Exception $e) {
            throw new UserMapDBException();
        } catch (NotFishingStatusException $e) {
            throw $e;
        }
    }

    public function findDepartureInfoByUserId($userId, $mapId)
    {
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

        } catch (Exception $e) {
            throw new UserMapDBException();
        }
        return $result;
    }

    public function findUserFishingPlaceByUserId($userId)
    {
        $query = "select m.map_id, m.max_depth, u.fishing from user_fishing_place u join map m on u.map_id = m.map_id where u.user_id = :user_id";

        $result = false;

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);
            $sth->execute();

            $result = $sth->fetch();

            if ($result) {
                $result = new UserFishingPlace($result['map_id'], $result['max_depth'], $result['fishing']);
            }
        } catch (Exception $exception) {
            throw new UserMapDBException();
        }
        return $result;
    }

    public function createUserMap($userId)
    {
        $query = "insert into user_fishing_place(user_id) values(:user_id)";

        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $this->db->commit();

        } catch (Exception $e) {
            throw new UserMapDBException();
        }
    }
}