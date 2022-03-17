<?php

namespace App\Infrastructure\Persistence\Weather;

use App\Domain\Weather\Weather;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class WeatherDBRepository extends BaseDBRepository
{
    public function findWeatherByUserId($userId) {
        $query = "select time, temperature, wind_direction_id, wind_speed, tide_time, tide_type, tide_power from user_weather where user_id = :user_id and DATE_FORMAT(time, '%Y.%m.%d.%H') = DATE_FORMAT(now(), '%Y.%m.%d.%H')";

        try {
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $result = $sth->fetch();
            if ($result) {
                $result = new Weather($result["time"], $result["temperature"], $result["wind_direction_id"]
                    , $result["wind_speed"], $result["tide_time"], $result["tide_type"], $result["tide_power"]);
            }
        } catch(Exception $e) {

        }
        return $result;
    }

    public function insertWeatherByUserId($userId, $result) {
        $query = "insert into user_weather values (:user_id, :time, :temperature, :wind_direction_id, :wind_speed, :tide_time, :tide_type, :tide_power)";

        $data = [
            ':user_id' => $userId,
            ':time' => $result->getTime(),
            ':temperature' => $result->getTemperature(),
            ':wind_direction_id' => $result->getWindDirectionId(),
            ':wind_speed' => $result->getWindSpeed(),
            ':tide_time' => $result->getTideTime(),
            ':tide_type' => $result->getTideType(),
            ':tide_power' => $result->getTidePower()
        ];
        try {
            $this->db->beginTransaction();

            $sth = $this->db->prepare($query);

            $sth->execute($data);

            $sth->fetch();

            $this->db->commit();
        } catch(Exception $e) {

        }
    }
}