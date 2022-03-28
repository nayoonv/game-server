<?php

namespace App\Infrastructure\Persistence\Equip;

use App\Domain\Equip\UserEquip;
use App\Domain\Equip\UserEquipUpgradeAvailable;
use App\Domain\Equip\UserEquipUpgradeUnavailable;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use Exception;

class UserEquipDBRepository extends BaseDBRepository
{
    public function findEquipByUserEquipId($userEquipId) {
        $query = "select *
                from user_equip
                where user_equip_id = :user_equip_id";
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_equip_id", $userEquipId);
            $sth->execute();

            $result = $sth->fetch();
            if ($result) {
                $result = new UserEquip($result['user_equip_id'], $result['user_id']
                    , $result['equip_id'], $result['upgrade_available']);
            }
        } catch(Exception $exception) {
            throw new UserEquipDBException();
        }
        return $result;
    }
    public function findUpgradeAvailableEquipByUserEquipId($userEquipId) {
        $query = "select e.equip_id, u.level, u.durability
                from user_equip e 
                join user_upgrade_equip u on e.user_equip_id = u.user_equip_id
                where e.user_equip_id = :user_equip_id";
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_equip_id", $userEquipId);
            $sth->execute();

            $result = $sth->fetch();
            if ($result) {
                $result = new UserEquipUpgradeAvailable($result['equip_id'], $result['level'], $result['durability']);
            }
        } catch(Exception $exception) {
            throw new UserEquipDBException();
        }
        return $result;
    }

    public function findUpgradeUnavailableEquipByUserEquipId($userEquipId) {
        $query = "select e.equip_id
                from user_equip e 
                where e.user_equip_id = :user_equip_id";
        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_equip_id", $userEquipId);
            $sth->execute();

            $result = $sth->fetch();
            if ($result) {
                $result = new UserEquipUpgradeUnavailable($result['equip_id']);
            }
        } catch(Exception $exception) {
            throw new UserEquipDBException();
        }
        return $result;
    }

    public function insertRod($userId, $equipId, $level, $preparationId) {
        $query = "insert into user_equip(user_id, equip_id, upgrade_available) values (:user_id, :equip_id, 1)";
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_id", $userId);
            $sth->bindParam(":equip_id", $equipId);

            $sth->execute();

            $userEquipId = $this->db->lastInsertId();

            $query = "insert into user_upgrade_equip(user_equip_id, level, value_for_level_up, durability) 
                values (:user_equip_id, :level, 0, (select rod_durability from rod_level where rod_id = :rod_id and rod_level = :level))";
            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_equip_id", $userEquipId);
            $sth->bindParam(":level", $level);
            $sth->bindParam(":rod_id", $preparationId);

            $sth->execute();

            $this->db->commit();

            return $userEquipId;
        } catch(Exception $e) {
            $this->db->rollBack();
            throw new UserEquipDBException();
        }
    }
    public function insertLine($userId, $equipId, $level, $preparationId) {
        $query = "insert into user_equip(user_id, equip_id, upgrade_available) values (:user_id, :equip_id, 1)";
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_id", $userId);
            $sth->bindParam(":equip_id", $equipId);

            $sth->execute();

            $userEquipId = $this->db->lastInsertId();

            $query = "insert into user_upgrade_equip(user_equip_id, level, value_for_level_up, durability) 
                values (:user_equip_id, :level, 0, -1)";

            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_equip_id", $userEquipId);
            $sth->bindParam(":level", $level);
            $sth->bindParam(":line_id", $preparationId);

            $sth->execute();

            $this->db->commit();

            return $userEquipId;
        } catch(Exception $e) {
            $this->db->rollBack();
            throw new UserEquipDBException();
        }
    }

    public function insertReel($userId, $equipId, $level, $preparationId) {
        $query = "insert into user_equip(user_id, equip_id, upgrade_available) values (:user_id, :equip_id, 1)";
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_id", $userId);
            $sth->bindParam(":equip_id", $equipId);

            $sth->execute();

            $userEquipId = $this->db->lastInsertId();

            $query = "insert into user_upgrade_equip(user_equip_id, level, value_for_level_up, durability) 
                values (:user_equip_id, :level, 0, (select reel_durability from reel_level where reel_id = :reel_id and reel_level = :level))";
            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_equip_id", $userEquipId);
            $sth->bindParam(":level", $level);
            $sth->bindParam(":reel_id", $preparationId);

            $sth->execute();

            $this->db->commit();

            return $userEquipId;
        } catch(Exception $e) {
            $this->db->rollBack();
            throw new UserEquipDBException();
        }
    }
    public function insertEquipUpgradeUnavailable($userId, $equipId) {
        $query = "insert into user_equip(user_id, equip_id, upgrade_available) values (:user_id, :equip_id, 0)";
        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(":user_id", $userId);
            $sth->bindParam(":equip_id", $equipId);

            $sth->execute();

            $userEquipId = $this->db->lastInsertId();
            $this->db->commit();

            return $userEquipId;
        } catch(Exception $e) {
            throw new UserEquipDBException();
        }
    }
}