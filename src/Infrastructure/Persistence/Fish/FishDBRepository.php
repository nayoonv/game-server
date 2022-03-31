<?php

namespace App\Infrastructure\Persistence\Fish;

use App\Domain\Fishing\AuctionFish;
use App\Domain\Fishing\Fish;
use App\Exception\Base\UrukException;
use App\Exception\Fish\FishDBException;
use App\Exception\Fish\FishNotExistsException;
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

    public function findByFishId($fishId) {
        $query = "select * from fish where fish_id = :fish_id";

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(":fish_id", $fishId);
            $sth->execute();

            $fish = $sth->fetch();

            if ($fish) {
                return new AuctionFish($fish['fish_grade_id'], $fish['max_length'], $fish['max_weight'], $fish['price']);
            } else {
                throw new FishNotExistsException();
            }
        } catch (FishNotExistsException $e) {
            throw $e;
        } catch (PDOException $exception) {
            throw new FishDBException();
        }
    }
}