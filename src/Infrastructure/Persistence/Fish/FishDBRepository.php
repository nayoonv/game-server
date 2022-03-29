<?php

namespace App\Infrastructure\Persistence\Fish;

use App\Domain\Fishing\Fish;
use App\Exception\Fish\FishDBException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use PDOException;

class FishDBRepository extends BaseDBRepository
{
    public function findByMapIdAndDistance($depth, $mapId, $grade) {
        $query = "select fish_id, fish_name, fish_grade_id, max_length, max_weight 
                from fish 
                where map_id = :map_id and fish_grade_id <= :grade_id
                and favorite_depth - depth_error_range < :depth and :depth < favorite_depth + depth_error_range;";
        $result = array();
        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':depth', $depth);
            $sth->bindParam(':grade_id', $grade);
            $sth->bindParam(':map_id', $mapId);
            $sth->execute();

            $fishes = $sth->fetchAll();

            if ($fishes) {
                foreach($fishes as &$fish) {
                    array_push($result, new Fish($fish['fish_id'], $fish['fish_name']
                        , $fish['fish_grade_id'], $fish['max_length'], $fish['max_weight']));
                }
            }
        } catch(PDOException $exception) {
            throw new FishDBException();
        }

        return $result;
    }
}