<?php

namespace App\Infrastructure\Persistence\Boat;

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

        }
    }
}