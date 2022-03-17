<?php

namespace App\Infrastructure\Persistence\Equip;

use App\Domain\Equip\UserEquipUpgradeAvailable;
use App\Domain\Equip\UserEquipUpgradeUnavailable;
use App\Infrastructure\Persistence\Base\BaseDBRepository;

class UserEquipDBRepository extends BaseDBRepository
{
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
        } catch(UserEquipNotExistsException $exception) {

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
        } catch(UserEquipNotExistsException $exception) {

        }
        return $result;
    }

}