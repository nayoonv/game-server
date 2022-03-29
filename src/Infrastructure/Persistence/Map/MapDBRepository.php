<?php

namespace App\Infrastructure\Persistence\Map;

use App\Domain\Map\Map;
use App\Exception\Base\UrukException;
use App\Exception\Map\MapDBException;
use App\Exception\Map\MapNotExistsException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class MapDBRepository extends BaseDBRepository
{
    public function findByMapId($mapId) {
        $query = "select * from map where map_id = :map_id";

        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(":map_id", $mapId);

            $sth->execute();

            $result = $sth->fetch();

            if ($result)
                return new Map($result['map_id'], $result['map_name'], $result['distance'], $result['cost_to_sail']
                    , $result['time_to_sail'], $result['level_limit'], $result['reduced_durability']);
            else
                throw new MapNotExistsException();
        } catch (Exception $exception) {
            throw new MapDBException();
        } catch (UrukException $e) {
            throw $e;
        }
    }
}