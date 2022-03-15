<?php

namespace App\Infrastructure\Persistence\Weather;

use App\Domain\Weather\Tide;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class TideDBRepository extends BaseDBRepository
{
    public function findTideByDateAndTime($date, $time) {
        $query = "select tide_type, tide_power from tide where tide_date = :tide_date and hour(tide_time) <= :tide_time order by hour(tide_time) desc limit 1;";

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':tide_date', $date);
            $sth->bindParam(':tide_time', $time);

            $sth->execute();

            $result = $sth->fetch();

            if (!$result) {
                $query = "select tide_type, tide_power from tide where tide_date = :tide_date order by hour(tide_time) desc limit 1;";
                $sth = $this->db->prepare($query);

                $date = ($date - 1) % 7 + 1;
                $sth->bindParam(':tide_date', $date);

                $sth->execute();

                $result = $sth->fetch();
            }
            if ($result)
                $result = new Tide($result["tide_type"], $result["tide_power"]);
        } catch (Exception $exception) {

        }

        return $result;
    }
}