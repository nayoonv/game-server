<?php

namespace App\Infrastructure\Persistence\Map;

use App\Domain\Map\Map;
use App\Exception\Map\MapDBException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class MapDBRepository extends BaseDBRepository
{
    public function findByMapId($mapId) {
        $query = "select * from map where map_id = :map_id";

        $result = false;
        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(":map_id", $mapId);

            $sth->execute();

            $result = $sth->fetch();

            if ($result)
                $result = new Map($result['map_id'], $result['map_name'], $result['distance'], $result['cost_to_sail']
                    , $result['time_to_sail'], $result['level_limit'], $result['reduced_durability']);

        } catch (MapDBException $exception) {

        }
        return $result;
    }
}