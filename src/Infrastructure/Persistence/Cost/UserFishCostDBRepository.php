<?php

namespace App\Infrastructure\Persistence\Cost;

use App\Infrastructure\Persistence\Base\BaseDBRepository;
use App\Service\Cost\UserFishCostDBException;
use PDOException;

class UserFishCostDBRepository extends BaseDBRepository
{
    public function insertCost($userId, $userFishInfo, $gold, $sellDate) {
        $query = "insert into user_fish_cost values (:user_id, :fish_id
            , (select f.map_id from fish f where f.fish_id = :fish_id), :cost
            , :time, :length, :weight, (select f.fish_grade_id from fish f where f.fish_id = :fish_id))";

        try {
            $data = [
                ":user_id" => $userId,
                ":fish_id" => $userFishInfo->getFishId(),
                ":cost" => $gold,
                ":time" => $sellDate,
                ":length" => $userFishInfo->getLength(),
                ":weight" => $userFishInfo->getWeight()
            ];
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->execute($data);

            $this->db->commit();
        } catch(PDOException $e) {
            throw new UserFishCostDBException();
        }
    }
}