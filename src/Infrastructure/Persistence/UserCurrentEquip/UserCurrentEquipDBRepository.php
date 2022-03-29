<?php

namespace App\Infrastructure\Persistence\UserCurrentEquip;

use App\Domain\UserCurrentEquip\UserCurrentEquip;
use App\Exception\Equip\UserCurrentEquipDBException;
use App\Exception\Equip\UserCurrentEquipNotExistsException;
use App\Infrastructure\Persistence\Base\BaseDBRepository;
use PDOException;

class UserCurrentEquipDBRepository extends BaseDBRepository
{
    public function findByUserId($userId) {
        $query = "select * from user_current_equip where user_id = :user_id";

        $result = false;

        try {
            $sth = $this->db->prepare($query);

            $sth->bindParam(':user_id', $userId);

            $sth->execute();

            $result = $sth->fetch();

            if ($result) {
                $result = new UserCurrentEquip($result['user_rod_id'], $result['user_line_id']
                    , $result['user_reel_id'], $result['user_hook_id'], $result['user_bait_id']
                    , $result['user_sinker_id']);
            } else
                throw new UserCurrentEquipNotExistsException();
        } catch (UserCurrentEquipNotExistsException $exception) {
            throw $exception;
        } catch (PDOException $exception) {
            throw new UserCurrentEquipDBException();
        }

        return $result;
    }

    public function updateRodByUserEquipId($userId, $userEquipId) {
        $query = "update user_current_equip set user_rod_id = :user_rod_id where user_id = :user_id";
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_rod_id', $userEquipId);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            throw new UserCurrentEquipDBException();
        }
    }

    public function updateLineByUserEquipId($userId, $userEquipId) {
        $query = "update user_current_equip set user_line_id = :user_line_id where user_id = :user_id";
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_line_id', $userEquipId);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            throw new UserCurrentEquipDBException();
        }
    }

    public function updateReelByUserEquipId($userId, $userEquipId) {
        $query = "update user_current_equip set user_reel_id = :user_reel_id where user_id = :user_id";
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_reel_id', $userEquipId);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            throw new UserCurrentEquipDBException();
        }
    }

    public function updateHookByUserEquipId($userId, $userEquipId) {
        $query = "update user_current_equip set user_hook_id = :user_hook_id where user_id = :user_id";
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_hook_id', $userEquipId);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            throw new UserCurrentEquipDBException();
        }
    }

    public function updateBaitByUserEquipId($userId, $userEquipId) {
        $query = "update user_current_equip set user_bait_id = :user_bait_id where user_id = :user_id";
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_bait_id', $userEquipId);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            throw new UserCurrentEquipDBException();
        }
    }

    public function updateSinkerByUserEquipId($userId, $userEquipId) {
        $query = "update user_current_equip set user_sinker_id = :user_sinker_id where user_id = :user_id";
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare($query);
            $sth->bindParam(':user_sinker_id', $userEquipId);
            $sth->bindParam(':user_id', $userId);

            $sth->execute();
            $this->db->commit();
        } catch (PDOException $e) {
            throw new UserCurrentEquipDBException();
        }
    }
}