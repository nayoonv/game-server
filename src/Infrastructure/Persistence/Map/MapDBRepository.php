<?php

namespace App\Infrastructure\Persistence\Map;

use App\Infrastructure\Persistence\Base\BaseDBRepository;

class MapDBRepository extends BaseDBRepository
{
    public function findLevelLimitByMapId($mapId) {
        $query = "select level_limit from map where map_id = :map_id";

        $levelLimit = 0;
        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(":map_id", $mapId);

            $sth->execute();

            $levelLimit = $sth->fetch();
            if (!$levelLimit)
                $levelLimit = $levelLimit["level_limit"];

        } catch (MapDBException $exception) {

        }

        return $levelLimit;
    }
}